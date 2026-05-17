<?php

namespace App\Admin\Controllers;

use App\Brand;
use App\BrandFaqItem;
use App\Site;
use App\State;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Encore\Admin\Layout\Content;
use ZipArchive;

class BrandExportImportController extends Controller
{
    /**
     * Show the export/import page.
     */
    public function index(Content $content)
    {
        $sites   = Site::orderBy('name')->get()->pluck('name', 'id');
        $session = session('brand_exim_result');
        session()->forget('brand_exim_result');

        return $content
            ->header('Brand Export / Import')
            ->description('Mass export and import brand data as JSON files inside a ZIP archive')
            ->body(view('admin.brand_exim', compact('sites', 'session')));
    }

    /**
     * POST /admin/brand_exim/export
     * Downloads a ZIP with per-brand JSON files, filtered by site (and optionally by brand).
     */
    public function export(Request $request)
    {
        $request->validate([
            'site_id'    => 'required|integer|exists:sites,id',
            'brand_ids'  => 'nullable|array',
            'brand_ids.*'=> 'integer',
        ]);

        $site = Site::findOrFail($request->site_id);

        $query = Brand::with(['brand_text_blocks', 'states', 'faq_items'])
            ->where('site_id', $site->id);

        if (!empty($request->brand_ids)) {
            $query->whereIn('id', $request->brand_ids);
        }

        $brands = $query->get();

        if ($brands->isEmpty()) {
            return back()->withErrors(['No brands found for the selected criteria.']);
        }

        $tmpPath = storage_path('app/temp/export_' . time());
        @mkdir($tmpPath, 0755, true);

        $zipName = 'brands_export_' . $site->slug . '_' . date('Ymd_His') . '.zip';
        $zipPath = $tmpPath . '/' . $zipName;

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE) !== true) {
            return back()->withErrors(['Could not create ZIP file.']);
        }

        foreach ($brands as $brand) {
            $folder = $brand->slug . '/';

            // brand.json — core fields
            $brandData = [
                'name'               => $brand->name,
                'slug'               => $brand->slug,
                'domain'             => $brand->domain,
                'active'             => (bool) $brand->active,
                'additional_domains' => $brand->getOriginal('additional_domains'),
                'meta_title'         => $brand->meta_title,
                'meta_description'   => $brand->meta_description,
                'meta_keywords'      => $brand->meta_keywords,
                'use_all_states'     => (bool) $brand->use_all_states,
                'main_image'         => $brand->main_image,
                'favicon'            => $brand->favicon,
            ];
            $zip->addFromString($folder . 'brand.json', json_encode($brandData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            // seo.json — extended SEO fields
            $seoData = [
                'og_title'          => $brand->og_title,
                'og_description'    => $brand->og_description,
                'og_image'          => $brand->og_image,
                'og_type'           => $brand->og_type,
                'twitter_card'      => $brand->twitter_card,
                'twitter_title'     => $brand->twitter_title,
                'twitter_description'=> $brand->twitter_description,
                'twitter_image'     => $brand->twitter_image,
                'canonical_url'     => $brand->canonical_url,
                'schema_org_json'   => $brand->schema_org_json,
            ];
            $zip->addFromString($folder . 'seo.json', json_encode($seoData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            // faq.json
            $faqData = $brand->faq_items->map(function ($item) {
                return [
                    'question' => $item->question,
                    'answer'   => $item->answer,
                    'position' => $item->position,
                    'active'   => (bool) $item->active,
                ];
            })->values()->all();
            $zip->addFromString($folder . 'faq.json', json_encode($faqData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            // text_blocks.json
            $textBlocksData = $brand->brand_text_blocks->map(function ($block) {
                return [
                    'var_name'    => $block->var_name,
                    'name'        => $block->name,
                    'description' => $block->description,
                    'active'      => (bool) $block->active,
                ];
            })->values()->all();
            $zip->addFromString($folder . 'text_blocks.json', json_encode($textBlocksData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            // states.json
            $statesData = $brand->states->pluck('slug')->values()->all();
            $zip->addFromString($folder . 'states.json', json_encode($statesData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }

        $zip->close();

        return response()->download($zipPath, $zipName)->deleteFileAfterSend(true);
    }

    /**
     * POST /admin/brand_exim/import
     * Accepts a ZIP, walks per-brand folders, updates DB records.
     */
    public function import(Request $request)
    {
        $request->validate([
            'zip_file' => 'required|file|mimes:zip',
            'site_id'  => 'required|integer|exists:sites,id',
            'dry_run'  => 'nullable|boolean',
        ]);

        $site   = Site::findOrFail($request->site_id);
        $dryRun = (bool) $request->input('dry_run', false);

        $tmpDir = storage_path('app/temp/import_' . time());
        @mkdir($tmpDir, 0755, true);

        $zip = new ZipArchive();
        $zipFile = $request->file('zip_file');

        if ($zip->open($zipFile->getRealPath()) !== true) {
            return back()->withErrors(['Could not open uploaded ZIP file.']);
        }

        $zip->extractTo($tmpDir);
        $zip->close();

        $result = [
            'updated' => [],
            'skipped' => [],
            'errors'  => [],
            'dry_run' => $dryRun,
            'site'    => $site->name,
        ];

        $allStates = State::all()->keyBy('slug');

        $brandDirs = glob($tmpDir . '/*', GLOB_ONLYDIR);

        foreach ($brandDirs as $brandDir) {
            $slug = basename($brandDir);

            $brand = Brand::where('slug', $slug)->where('site_id', $site->id)->first();

            if (!$brand) {
                $result['skipped'][] = $slug . ' (brand not found in site "' . $site->name . '")';
                continue;
            }

            try {
                // brand.json
                if (file_exists($brandDir . '/brand.json')) {
                    $data = json_decode(file_get_contents($brandDir . '/brand.json'), true);
                    if ($data) {
                        $updateFields = array_intersect_key($data, array_flip([
                            'meta_title', 'meta_description', 'meta_keywords',
                            'active', 'use_all_states', 'additional_domains',
                        ]));
                        if (!$dryRun) {
                            $brand->fill($updateFields)->save();
                        }
                    }
                }

                // seo.json
                if (file_exists($brandDir . '/seo.json')) {
                    $seo = json_decode(file_get_contents($brandDir . '/seo.json'), true);
                    if ($seo) {
                        $seoFields = array_intersect_key($seo, array_flip([
                            'og_title', 'og_description', 'og_image', 'og_type',
                            'twitter_card', 'twitter_title', 'twitter_description', 'twitter_image',
                            'canonical_url', 'schema_org_json',
                        ]));
                        if (!$dryRun) {
                            $brand->fill($seoFields)->save();
                        }
                    }
                }

                // faq.json — replace all active FAQ items
                if (file_exists($brandDir . '/faq.json')) {
                    $faqs = json_decode(file_get_contents($brandDir . '/faq.json'), true);
                    if (is_array($faqs)) {
                        if (!$dryRun) {
                            $brand->faq_items()->delete();
                            foreach ($faqs as $faqItem) {
                                $brand->faq_items()->create([
                                    'question' => $faqItem['question'] ?? '',
                                    'answer'   => $faqItem['answer'] ?? '',
                                    'position' => $faqItem['position'] ?? 0,
                                    'active'   => $faqItem['active'] ?? true,
                                ]);
                            }
                        }
                    }
                }

                // text_blocks.json — update only by var_name (never create/delete)
                if (file_exists($brandDir . '/text_blocks.json')) {
                    $blocks = json_decode(file_get_contents($brandDir . '/text_blocks.json'), true);
                    if (is_array($blocks)) {
                        foreach ($blocks as $blockData) {
                            if (empty($blockData['var_name'])) continue;
                            if (!$dryRun) {
                                $brand->brand_text_blocks()
                                    ->where('var_name', $blockData['var_name'])
                                    ->update([
                                        'description' => $blockData['description'] ?? null,
                                        'active'      => $blockData['active'] ?? true,
                                    ]);
                            }
                        }
                    }
                }

                // states.json — re-sync pivot
                if (file_exists($brandDir . '/states.json')) {
                    $stateSlugs = json_decode(file_get_contents($brandDir . '/states.json'), true);
                    if (is_array($stateSlugs)) {
                        $stateIds = collect($stateSlugs)
                            ->map(function ($s) use ($allStates) {
                                $state = $allStates->get($s);
                                return $state ? $state->id : null;
                            })
                            ->filter()
                            ->values()
                            ->all();
                        if (!$dryRun) {
                            $brand->states()->sync($stateIds);
                        }
                    }
                }

                $result['updated'][] = $slug;
            } catch (\Throwable $e) {
                $result['errors'][] = $slug . ': ' . $e->getMessage();
            }
        }

        // cleanup temp dir
        $this->deleteDirectory($tmpDir);

        session(['brand_exim_result' => $result]);

        return redirect()->route(config('admin.route.prefix') . '.brand_exim.index');
    }

    /**
     * GET /admin/brand_exim/brands?site_id=X
     * Returns brands for a site as JSON (used by the export form JS).
     */
    public function brandsForSite(Request $request)
    {
        $brands = Brand::where('site_id', $request->site_id)
            ->orderBy('name')
            ->get(['id', 'name', 'domain']);

        return response()->json($brands);
    }

    private function deleteDirectory(string $dir): void
    {
        if (!is_dir($dir)) return;
        foreach (glob($dir . '/*') as $item) {
            is_dir($item) ? $this->deleteDirectory($item) : unlink($item);
        }
        rmdir($dir);
    }
}
