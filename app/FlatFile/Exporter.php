<?php

namespace App\FlatFile;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Exports content tables from the default MySQL connection into content/ JSON files.
 */
class Exporter
{
    /** @var Store */
    protected $store;

    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    /**
     * @param string $table
     * @return bool
     */
    protected function hasTable($table)
    {
        try {
            return Schema::connection(config('database.default'))->hasTable($table);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param bool $dryRun
     * @return array summary counts
     */
    public function export($dryRun = false)
    {
        $this->store->ensureContentDir();
        $summary = [];

        if (!$this->hasTable('brands')) {
            throw new \RuntimeException('Table brands not found on default DB connection.');
        }

        $brands = DB::connection()->table('brands')->get();
        Paths::$brandSlugMap = [];
        foreach ($brands as $brand) {
            $arr = (array) $brand;
            if (!empty($arr['slug'])) {
                Paths::$brandSlugMap[$arr['id']] = $arr['slug'];
            } else {
                Paths::$brandSlugMap[$arr['id']] = 'id-' . $arr['id'];
            }
        }

        $summary['sites'] = $this->exportTable('sites', $dryRun);
        $summary['states'] = $this->exportTable('states', $dryRun);
        $summary['brands'] = $this->exportBrands($dryRun);
        $summary['brand_states'] = $this->exportBrandStates($dryRun);
        $summary['brand_faq_items'] = $this->exportBrandFaqs($dryRun);
        $summary['brand_text_blocks'] = $this->exportBrandTextBlocks($dryRun);
        $summary['brand_brand_feature'] = $this->exportBrandFeatureValues($dryRun);
        $summary['brand_model_line'] = $this->exportBrandModelLines($dryRun);
        $summary['categories'] = $this->exportTable('categories', $dryRun);
        $summary['category_brands'] = $this->exportCategoryBrands($dryRun);
        $summary['products'] = $this->exportTable('products', $dryRun);
        $summary['articles'] = $this->exportTable('articles', $dryRun);
        $summary['text_blocks'] = $this->exportTable('text_blocks', $dryRun);
        $summary['menus'] = $this->exportTable('menus', $dryRun);
        $summary['page_templates'] = $this->exportTable('page_templates', $dryRun);
        $summary['page_brand_templates'] = $this->exportTable('page_brand_templates', $dryRun);
        $summary['category_templates'] = $this->exportTable('category_templates', $dryRun);
        $summary['category_page_templates'] = $this->exportTable('category_page_templates', $dryRun);
        $summary['model_lines'] = $this->exportTable('model_lines', $dryRun);
        $summary['model_line_templates'] = $this->exportTable('model_line_templates', $dryRun);
        $summary['brand_features'] = $this->exportTable('brand_features', $dryRun);
        $formSummary = $this->exportForms($dryRun);
        $summary['custom_forms'] = $formSummary['forms'];
        $summary['form_fields'] = $formSummary['fields'];

        return $summary;
    }

    /**
     * @param string $table
     * @param bool   $dryRun
     * @return int
     */
    protected function exportTable($table, $dryRun)
    {
        if (!$this->hasTable($table)) {
            return 0;
        }

        $rows = DB::connection()->table($table)->get();
        $count = 0;
        foreach ($rows as $row) {
            $arr = $this->rowToArray($row);
            $path = Paths::forRow($table, $arr);
            if (!$path) {
                continue;
            }
            if (!$dryRun) {
                $this->store->write($path, $arr);
            }
            $count++;
        }

        return $count;
    }

    /**
     * @param bool $dryRun
     * @return int
     */
    protected function exportBrands($dryRun)
    {
        $rows = DB::connection()->table('brands')->get();
        $count = 0;
        $seoKeys = [
            'og_title', 'og_description', 'og_image', 'og_type',
            'twitter_card', 'twitter_title', 'twitter_description', 'twitter_image',
            'canonical_url', 'schema_org_json',
        ];

        foreach ($rows as $row) {
            $arr = $this->rowToArray($row);
            $slug = !empty($arr['slug']) ? $arr['slug'] : ('id-' . $arr['id']);
            $seo = [];
            foreach ($seoKeys as $key) {
                if (array_key_exists($key, $arr)) {
                    $seo[$key] = $arr[$key];
                    unset($arr[$key]);
                }
            }
            if (!$dryRun) {
                if (!empty($arr['domain'])) {
                    $arr['domain'] = strtolower($arr['domain']);
                }
                if (!empty($arr['additional_domains'])) {
                    $arr['additional_domains'] = strtolower($arr['additional_domains']);
                }
                $this->store->write('brands/' . $slug . '/brand.json', $arr);
                $this->store->write('brands/' . $slug . '/seo.json', $seo);
            }
            $count++;
        }

        return $count;
    }

    /**
     * @param bool $dryRun
     * @return int
     */
    protected function exportBrandStates($dryRun)
    {
        if (!$this->hasTable('brand_states')) {
            return 0;
        }

        $count = 0;
        foreach (Paths::$brandSlugMap as $brandId => $slug) {
            $stateIds = DB::connection()->table('brand_states')
                ->where('brand_id', $brandId)
                ->pluck('state_id')
                ->all();
            // Laravel 5.7 pluck may return Collection
            if (is_object($stateIds) && method_exists($stateIds, 'all')) {
                $stateIds = $stateIds->all();
            }
            $stateIds = array_map('intval', (array) $stateIds);
            if (!$dryRun) {
                $this->store->write('brands/' . $slug . '/states.json', array_values($stateIds));
            }
            $count += count($stateIds);
        }

        return $count;
    }

    /**
     * @param bool $dryRun
     * @return int
     */
    protected function exportBrandFaqs($dryRun)
    {
        $count = 0;
        $hasFaq = $this->hasTable('brand_faq_items');

        foreach (Paths::$brandSlugMap as $brandId => $slug) {
            $list = [];
            if ($hasFaq) {
                $items = DB::connection()->table('brand_faq_items')
                    ->where('brand_id', $brandId)
                    ->orderBy('position')
                    ->get();
                foreach ($items as $item) {
                    $list[] = $this->rowToArray($item);
                    $count++;
                }
            }
            if (!$dryRun) {
                $this->store->write('brands/' . $slug . '/faq.json', $list);
            }
        }

        return $count;
    }

    /**
     * @param bool $dryRun
     * @return int
     */
    protected function exportBrandTextBlocks($dryRun)
    {
        if (!$this->hasTable('brand_text_blocks')) {
            return 0;
        }

        $rows = DB::connection()->table('brand_text_blocks')->get();
        $count = 0;
        foreach ($rows as $row) {
            $arr = $this->rowToArray($row);
            $slug = Paths::brandSlugById($arr['brand_id']);
            if (!$slug) {
                $slug = 'id-' . $arr['brand_id'];
            }
            if (!$dryRun) {
                $this->store->write('brands/' . $slug . '/text_blocks/' . $arr['id'] . '.json', $arr);
            }
            $count++;
        }

        return $count;
    }

    /**
     * @param bool $dryRun
     * @return int
     */
    protected function exportBrandFeatureValues($dryRun)
    {
        if (!$this->hasTable('brand_brand_feature')) {
            return 0;
        }

        $rows = DB::connection()->table('brand_brand_feature')->get();
        $count = 0;
        foreach ($rows as $row) {
            $arr = $this->rowToArray($row);
            $slug = Paths::brandSlugById($arr['brand_id']);
            if (!$slug) {
                $slug = 'id-' . $arr['brand_id'];
            }
            if (!$dryRun) {
                $this->store->write('brands/' . $slug . '/feature_values/' . $arr['id'] . '.json', $arr);
            }
            $count++;
        }

        return $count;
    }

    /**
     * @param bool $dryRun
     * @return int
     */
    protected function exportBrandModelLines($dryRun)
    {
        if (!$this->hasTable('brand_model_line')) {
            return 0;
        }

        $count = 0;
        foreach (Paths::$brandSlugMap as $brandId => $slug) {
            $rows = DB::connection()->table('brand_model_line')->where('brand_id', $brandId)->get();
            $list = [];
            foreach ($rows as $row) {
                $list[] = $this->rowToArray($row);
                $count++;
            }
            if (!$dryRun) {
                $this->store->write('brands/' . $slug . '/model_lines.json', $list);
            }
        }

        return $count;
    }

    /**
     * @param bool $dryRun
     * @return int
     */
    protected function exportCategoryBrands($dryRun)
    {
        if (!$this->hasTable('category_brands')) {
            return 0;
        }

        $rows = DB::connection()->table('category_brands')->get();
        $list = [];
        foreach ($rows as $row) {
            $list[] = $this->rowToArray($row);
        }
        if (!$dryRun) {
            $this->store->write('category_brands.json', $list);
        }

        return count($list);
    }

    /**
     * @param bool $dryRun
     * @return array
     */
    protected function exportForms($dryRun)
    {
        if (!$this->hasTable('custom_forms')) {
            return ['forms' => 0, 'fields' => 0];
        }

        $forms = DB::connection()->table('custom_forms')->get();
        $fieldCount = 0;
        $formCount = 0;
        $hasFields = $this->hasTable('form_fields');
        foreach ($forms as $form) {
            $arr = $this->rowToArray($form);
            $fieldList = [];
            if ($hasFields) {
                $fields = DB::connection()->table('form_fields')
                    ->where('custom_form_id', $arr['id'])
                    ->orderBy('position')
                    ->get();
                foreach ($fields as $field) {
                    $fieldList[] = $this->rowToArray($field);
                    $fieldCount++;
                }
            }
            $arr['fields'] = $fieldList;
            if (!$dryRun) {
                $this->store->write('forms/' . $arr['id'] . '.json', $arr);
            }
            $formCount++;
        }

        return ['forms' => $formCount, 'fields' => $fieldCount];
    }

    /**
     * @param object $row
     * @return array
     */
    protected function rowToArray($row)
    {
        return json_decode(json_encode($row), true);
    }
}
