<?php

namespace App\FlatFile;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Writes a model (and related aggregate files) back to content/ after SQLite save.
 */
class Writer
{
    /** @var Store */
    protected $store;

    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    /**
     * Persist model attributes to the appropriate JSON file(s).
     *
     * @param Model $model
     */
    public function writeModel(Model $model)
    {
        $table = $model->getTable();
        $arr = $model->getAttributes();

        if ($table === 'brands') {
            $this->writeBrand($arr);
            $this->writeBrandAggregates((int) $arr['id'], !empty($arr['slug']) ? $arr['slug'] : ('id-' . $arr['id']));
        } elseif ($table === 'custom_forms') {
            $this->writeForm((int) $arr['id']);
        } elseif ($table === 'form_fields') {
            if (!empty($arr['custom_form_id'])) {
                $this->writeForm((int) $arr['custom_form_id']);
            }
        } elseif ($table === 'brand_faq_items') {
            if (!empty($arr['brand_id'])) {
                $this->writeBrandFaqs((int) $arr['brand_id']);
            }
        } else {
            $path = Paths::forRow($table, $arr);
            if ($path) {
                $this->store->write($path, $arr);
            }
        }

        // Keep SQLite mtime >= content JSON so auto-rebuild does not fire after admin saves.
        app(Index::class)->markIndexFresh();
    }

    /**
     * @param Model $model
     */
    public function deleteModel(Model $model)
    {
        $table = $model->getTable();
        $arr = $model->getAttributes();

        if ($table === 'brands') {
            $slug = !empty($arr['slug']) ? $arr['slug'] : ('id-' . $arr['id']);
            $this->store->deleteDirectory('brands/' . $slug);
        } elseif ($table === 'custom_forms') {
            $this->store->delete('forms/' . $arr['id'] . '.json');
        } elseif ($table === 'form_fields' && !empty($arr['custom_form_id'])) {
            $this->writeForm((int) $arr['custom_form_id']);
        } elseif ($table === 'brand_faq_items' && !empty($arr['brand_id'])) {
            $this->writeBrandFaqs((int) $arr['brand_id']);
        } else {
            $path = Paths::forRow($table, $arr);
            if ($path) {
                $this->store->delete($path);
            }
        }

        app(Index::class)->markIndexFresh();
    }

    /**
     * @param array $arr
     */
    protected function writeBrand(array $arr)
    {
        $slug = !empty($arr['slug']) ? $arr['slug'] : ('id-' . $arr['id']);
        $seoKeys = [
            'og_title', 'og_description', 'og_image', 'og_type',
            'twitter_card', 'twitter_title', 'twitter_description', 'twitter_image',
            'canonical_url', 'schema_org_json',
        ];
        $seo = [];
        $brand = $arr;
        foreach ($seoKeys as $key) {
            if (array_key_exists($key, $brand)) {
                $seo[$key] = $brand[$key];
                unset($brand[$key]);
            }
        }
        // additional_domains may be accessor-transformed; store raw if possible
        $this->store->write('brands/' . $slug . '/brand.json', $brand);
        $this->store->write('brands/' . $slug . '/seo.json', $seo);
        Paths::$brandSlugMap[$arr['id']] = $slug;
    }

    /**
     * Refresh pivot aggregate files for a brand from the flat SQLite connection.
     *
     * @param int    $brandId
     * @param string $slug
     */
    public function writeBrandAggregates($brandId, $slug)
    {
        $conn = config('flat.enabled') ? 'flat' : null;

        $stateIds = DB::connection($conn)->table('brand_states')
            ->where('brand_id', $brandId)
            ->pluck('state_id');
        if (is_object($stateIds) && method_exists($stateIds, 'all')) {
            $stateIds = $stateIds->all();
        }
        $this->store->write('brands/' . $slug . '/states.json', array_map('intval', (array) $stateIds));

        $modelLines = DB::connection($conn)->table('brand_model_line')
            ->where('brand_id', $brandId)
            ->get();
        $list = [];
        foreach ($modelLines as $row) {
            $list[] = json_decode(json_encode($row), true);
        }
        $this->store->write('brands/' . $slug . '/model_lines.json', $list);

        $this->writeBrandFaqs($brandId, $slug);
    }

    /**
     * @param int         $brandId
     * @param string|null $slug
     */
    public function writeBrandFaqs($brandId, $slug = null)
    {
        if (!$slug) {
            $slug = $this->resolveBrandSlug($brandId);
        }
        if (!$slug) {
            return;
        }

        $conn = config('flat.enabled') ? 'flat' : null;
        $items = DB::connection($conn)->table('brand_faq_items')
            ->where('brand_id', $brandId)
            ->orderBy('position')
            ->get();
        $list = [];
        foreach ($items as $item) {
            $list[] = json_decode(json_encode($item), true);
        }
        $this->store->write('brands/' . $slug . '/faq.json', $list);
    }

    /**
     * @param int $formId
     */
    public function writeForm($formId)
    {
        $conn = config('flat.enabled') ? 'flat' : null;
        $form = DB::connection($conn)->table('custom_forms')->where('id', $formId)->first();
        if (!$form) {
            $this->store->delete('forms/' . $formId . '.json');
            return;
        }
        $arr = json_decode(json_encode($form), true);
        $fields = DB::connection($conn)->table('form_fields')
            ->where('custom_form_id', $formId)
            ->orderBy('position')
            ->get();
        $fieldList = [];
        foreach ($fields as $field) {
            $fieldList[] = json_decode(json_encode($field), true);
        }
        $arr['fields'] = $fieldList;
        $this->store->write('forms/' . $formId . '.json', $arr);
    }

    /**
     * @param int $brandId
     * @return string|null
     */
    protected function resolveBrandSlug($brandId)
    {
        if (isset(Paths::$brandSlugMap[$brandId])) {
            return Paths::$brandSlugMap[$brandId];
        }
        $conn = config('flat.enabled') ? 'flat' : null;
        $brand = DB::connection($conn)->table('brands')->where('id', $brandId)->first();
        if ($brand && !empty($brand->slug)) {
            return $brand->slug;
        }
        if ($brand) {
            return 'id-' . $brand->id;
        }

        return null;
    }
}
