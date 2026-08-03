<?php

namespace App\FlatFile;

/**
 * Maps Eloquent models / tables to content/ relative paths.
 */
class Paths
{
    /**
     * Relative path for a single model record.
     *
     * @param string $table
     * @param array  $row
     * @return string|null
     */
    public static function forRow($table, array $row)
    {
        $id = isset($row['id']) ? $row['id'] : null;

        switch ($table) {
            case 'sites':
                return 'sites/' . $id . '.json';

            case 'brands':
                $slug = !empty($row['slug']) ? $row['slug'] : ('id-' . $id);
                return 'brands/' . $slug . '/brand.json';

            case 'states':
                return 'states/' . $id . '.json';

            case 'categories':
                return 'categories/' . $id . '.json';

            case 'products':
                return 'products/' . $id . '.json';

            case 'articles':
                return 'articles/' . $id . '.json';

            case 'text_blocks':
                return 'text_blocks/' . $id . '.json';

            case 'brand_text_blocks':
                return self::brandChildPath($row, 'text_blocks/' . $id . '.json');

            case 'brand_faq_items':
                // Stored as array file per brand; individual path not used for write-one
                return null;

            case 'menus':
                return 'menus/' . $id . '.json';

            case 'page_templates':
                return 'page_templates/' . $id . '.json';

            case 'page_brand_templates':
                return 'page_brand_templates/' . $id . '.json';

            case 'category_templates':
                return 'category_templates/' . $id . '.json';

            case 'category_page_templates':
                return 'category_page_templates/' . $id . '.json';

            case 'model_lines':
                return 'model_lines/' . $id . '.json';

            case 'model_line_templates':
                return 'model_line_templates/' . $id . '.json';

            case 'brand_features':
                return 'brand_features/' . $id . '.json';

            case 'brand_brand_feature':
                return self::brandChildPath($row, 'feature_values/' . $id . '.json');

            case 'custom_forms':
                return 'forms/' . $id . '.json';

            case 'form_fields':
                // Nested inside forms/{id}.json
                return null;

            default:
                return null;
        }
    }

    /**
     * Glob pattern to load all rows for a table from content/.
     *
     * @param string $table
     * @return string|null
     */
    public static function globForTable($table)
    {
        switch ($table) {
            case 'sites':
                return 'sites/*.json';
            case 'brands':
                return 'brands/*/brand.json';
            case 'states':
                return 'states/*.json';
            case 'categories':
                return 'categories/*.json';
            case 'products':
                return 'products/*.json';
            case 'articles':
                return 'articles/*.json';
            case 'text_blocks':
                return 'text_blocks/*.json';
            case 'brand_text_blocks':
                return 'brands/*/text_blocks/*.json';
            case 'menus':
                return 'menus/*.json';
            case 'page_templates':
                return 'page_templates/*.json';
            case 'page_brand_templates':
                return 'page_brand_templates/*.json';
            case 'category_templates':
                return 'category_templates/*.json';
            case 'category_page_templates':
                return 'category_page_templates/*.json';
            case 'model_lines':
                return 'model_lines/*.json';
            case 'model_line_templates':
                return 'model_line_templates/*.json';
            case 'brand_features':
                return 'brand_features/*.json';
            case 'brand_brand_feature':
                return 'brands/*/feature_values/*.json';
            case 'custom_forms':
                return 'forms/*.json';
            case 'brand_faq_items':
                return 'brands/*/faq.json';
            case 'brand_states':
                return 'brands/*/states.json';
            case 'brand_model_line':
                return 'brands/*/model_lines.json';
            case 'category_brands':
                return 'category_brands.json';
            case 'form_fields':
                return 'forms/*.json';
            default:
                return null;
        }
    }

    /**
     * @param array  $row
     * @param string $suffix
     * @return string|null
     */
    protected static function brandChildPath(array $row, $suffix)
    {
        $brandId = isset($row['brand_id']) ? $row['brand_id'] : null;
        if (!$brandId) {
            return null;
        }

        $slug = self::brandSlugById($brandId);
        if (!$slug) {
            $slug = 'id-' . $brandId;
        }

        return 'brands/' . $slug . '/' . $suffix;
    }

    /**
     * Resolve brand slug from in-memory map or database.
     *
     * @param int $brandId
     * @return string|null
     */
    public static function brandSlugById($brandId)
    {
        if (isset(self::$brandSlugMap[$brandId])) {
            return self::$brandSlugMap[$brandId];
        }

        try {
            $conn = config('flat.enabled') ? 'flat' : config('database.default');
            $brand = \Illuminate\Support\Facades\DB::connection($conn)
                ->table('brands')
                ->where('id', $brandId)
                ->first();
            if ($brand && !empty($brand->slug)) {
                self::$brandSlugMap[$brandId] = $brand->slug;
                return $brand->slug;
            }
            if ($brand) {
                $fallback = 'id-' . $brand->id;
                self::$brandSlugMap[$brandId] = $fallback;
                return $fallback;
            }
        } catch (\Exception $e) {
            // ignore
        }

        return null;
    }

    /**
     * @var array
     */
    public static $brandSlugMap = [];

    /**
     * Brand folder relative path.
     *
     * @param string $slug
     * @return string
     */
    public static function brandDir($slug)
    {
        return 'brands/' . $slug;
    }
}
