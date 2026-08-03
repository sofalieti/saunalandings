<?php

namespace App\FlatFile;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

/**
 * Builds / refreshes storage/flat/content.sqlite from content/ JSON files.
 */
class Index
{
    /** @var Store */
    protected $store;

    /** @var Schema */
    protected $schema;

    public function __construct(Store $store, Schema $schema)
    {
        $this->store = $store;
        $this->schema = $schema;
    }

    /**
     * Ensure SQLite file + directory exist, recreate schema, load all content.
     *
     * @return array counts per table
     */
    public function rebuild()
    {
        $sqlitePath = config('flat.sqlite_path');
        $dir = dirname($sqlitePath);
        if (!File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        if (File::exists($sqlitePath)) {
            // Close connection before deleting
            DB::purge('flat');
            File::delete($sqlitePath);
        }

        File::put($sqlitePath, '');
        DB::purge('flat');
        DB::reconnect('flat');

        $this->schema->migrate();

        $counts = [];
        $counts['sites'] = $this->loadSimpleTable('sites');
        $counts['states'] = $this->loadSimpleTable('states');
        $counts['brands'] = $this->loadBrands();
        $counts['brand_states'] = $this->loadBrandStates();
        $counts['brand_faq_items'] = $this->loadBrandFaqs();
        $counts['brand_text_blocks'] = $this->loadSimpleTable('brand_text_blocks');
        $counts['brand_brand_feature'] = $this->loadSimpleTable('brand_brand_feature');
        $counts['brand_model_line'] = $this->loadBrandModelLines();
        $counts['categories'] = $this->loadSimpleTable('categories');
        $counts['category_brands'] = $this->loadCategoryBrands();
        $counts['products'] = $this->loadSimpleTable('products');
        $counts['articles'] = $this->loadSimpleTable('articles');
        $counts['text_blocks'] = $this->loadSimpleTable('text_blocks');
        $counts['menus'] = $this->loadSimpleTable('menus');
        $counts['page_templates'] = $this->loadSimpleTable('page_templates');
        $counts['page_brand_templates'] = $this->loadSimpleTable('page_brand_templates');
        $counts['category_templates'] = $this->loadSimpleTable('category_templates');
        $counts['category_page_templates'] = $this->loadSimpleTable('category_page_templates');
        $counts['model_lines'] = $this->loadSimpleTable('model_lines');
        $counts['model_line_templates'] = $this->loadSimpleTable('model_line_templates');
        $counts['brand_features'] = $this->loadSimpleTable('brand_features');
        $formCounts = $this->loadForms();
        $counts['custom_forms'] = $formCounts['forms'];
        $counts['form_fields'] = $formCounts['fields'];

        $this->fixAutoIncrements();

        return $counts;
    }

    /**
     * Keep SQLite AUTOINCREMENT sequences above max(id) for each table.
     */
    protected function fixAutoIncrements()
    {
        $tablesWithId = array_filter(config('flat.tables'), function ($table) {
            return $table !== 'brand_states';
        });

        foreach ($tablesWithId as $table) {
            try {
                $max = DB::connection('flat')->table($table)->max('id');
                if (!$max) {
                    continue;
                }
                // sqlite_sequence may not exist until first autoincrement insert
                DB::connection('flat')->statement(
                    'INSERT OR REPLACE INTO sqlite_sequence(name, seq) VALUES (?, ?)',
                    [$table, (int) $max]
                );
            } catch (\Exception $e) {
                // Ignore if sqlite_sequence is unavailable
            }
        }
    }

    /**
     * @param string $table
     * @return int
     */
    protected function loadSimpleTable($table)
    {
        $pattern = Paths::globForTable($table);
        if (!$pattern) {
            return 0;
        }

        $count = 0;
        foreach ($this->store->glob($pattern) as $relative) {
            $data = $this->store->read($relative);
            if (!$data || !isset($data['id'])) {
                continue;
            }
            // Skip aggregate files that are arrays without id at root
            if ($this->isList($data)) {
                continue;
            }
            $this->insertRow($table, $data);
            $count++;
        }

        return $count;
    }

    /**
     * @return int
     */
    protected function loadBrands()
    {
        $count = 0;
        foreach ($this->store->glob('brands/*/brand.json') as $relative) {
            $data = $this->store->read($relative);
            if (!$data || !isset($data['id'])) {
                continue;
            }
            // Merge seo.json if present
            $dir = dirname($relative);
            $seo = $this->store->read($dir . '/seo.json');
            if (is_array($seo)) {
                $data = array_merge($data, $seo);
            }
            $this->insertRow('brands', $data);
            if (!empty($data['slug'])) {
                Paths::$brandSlugMap[$data['id']] = $data['slug'];
            }
            $count++;
        }

        return $count;
    }

    /**
     * @return int
     */
    protected function loadBrandStates()
    {
        $count = 0;
        foreach ($this->store->glob('brands/*/states.json') as $relative) {
            $data = $this->store->read($relative);
            if (!is_array($data)) {
                continue;
            }
            $brandId = $this->brandIdFromPath($relative);
            foreach ($data as $item) {
                $stateId = is_array($item) ? (isset($item['id']) ? $item['id'] : (isset($item['state_id']) ? $item['state_id'] : null)) : $item;
                if (!$brandId || !$stateId) {
                    continue;
                }
                DB::connection('flat')->table('brand_states')->insert([
                    'brand_id' => (int) $brandId,
                    'state_id' => (int) $stateId,
                ]);
                $count++;
            }
        }

        return $count;
    }

    /**
     * @return int
     */
    protected function loadBrandFaqs()
    {
        $count = 0;
        foreach ($this->store->glob('brands/*/faq.json') as $relative) {
            $data = $this->store->read($relative);
            if (!is_array($data)) {
                continue;
            }
            $brandId = $this->brandIdFromPath($relative);
            foreach ($data as $item) {
                if (!is_array($item) || !isset($item['id'])) {
                    continue;
                }
                if (empty($item['brand_id']) && $brandId) {
                    $item['brand_id'] = $brandId;
                }
                $this->insertRow('brand_faq_items', $item);
                $count++;
            }
        }

        return $count;
    }

    /**
     * @return int
     */
    protected function loadBrandModelLines()
    {
        $count = 0;
        foreach ($this->store->glob('brands/*/model_lines.json') as $relative) {
            $data = $this->store->read($relative);
            if (!is_array($data)) {
                continue;
            }
            $brandId = $this->brandIdFromPath($relative);
            foreach ($data as $item) {
                if (is_array($item) && isset($item['id'])) {
                    $this->insertRow('brand_model_line', $item);
                } elseif (is_array($item) && isset($item['model_line_id'])) {
                    $row = [
                        'id' => isset($item['pivot_id']) ? $item['pivot_id'] : null,
                        'brand_id' => isset($item['brand_id']) ? $item['brand_id'] : $brandId,
                        'model_line_id' => $item['model_line_id'],
                        'created_at' => isset($item['created_at']) ? $item['created_at'] : null,
                        'updated_at' => isset($item['updated_at']) ? $item['updated_at'] : null,
                    ];
                    if ($row['id']) {
                        $this->insertRow('brand_model_line', $row);
                    } else {
                        unset($row['id']);
                        DB::connection('flat')->table('brand_model_line')->insert($row);
                    }
                } else {
                    $modelLineId = is_array($item) ? null : $item;
                    if ($brandId && $modelLineId) {
                        DB::connection('flat')->table('brand_model_line')->insert([
                            'brand_id' => (int) $brandId,
                            'model_line_id' => (int) $modelLineId,
                        ]);
                    }
                }
                $count++;
            }
        }

        return $count;
    }

    /**
     * @return int
     */
    protected function loadCategoryBrands()
    {
        $data = $this->store->read('category_brands.json');
        if (!is_array($data)) {
            return 0;
        }
        $count = 0;
        foreach ($data as $row) {
            if (!is_array($row) || !isset($row['id'])) {
                continue;
            }
            $this->insertRow('category_brands', $row);
            $count++;
        }

        return $count;
    }

    /**
     * @return array
     */
    protected function loadForms()
    {
        $forms = 0;
        $fields = 0;
        foreach ($this->store->glob('forms/*.json') as $relative) {
            $data = $this->store->read($relative);
            if (!$data || !isset($data['id'])) {
                continue;
            }
            $fieldRows = isset($data['fields']) && is_array($data['fields']) ? $data['fields'] : [];
            unset($data['fields']);
            $this->insertRow('custom_forms', $data);
            $forms++;
            foreach ($fieldRows as $field) {
                if (!is_array($field) || !isset($field['id'])) {
                    continue;
                }
                $this->insertRow('form_fields', $field);
                $fields++;
            }
        }

        return ['forms' => $forms, 'fields' => $fields];
    }

    /**
     * @param string $table
     * @param array  $data
     */
    protected function insertRow($table, array $data)
    {
        // Only keep columns that exist — strip unknown keys
        $columns = $this->columns($table);
        $row = [];
        foreach ($columns as $col) {
            if (array_key_exists($col, $data)) {
                $row[$col] = $data[$col];
            }
        }
        if (!isset($row['id'])) {
            return;
        }

        // Force insert with explicit id (SQLite)
        DB::connection('flat')->table($table)->insert($row);
    }

    /**
     * @param string $table
     * @return array
     */
    protected function columns($table)
    {
        static $cache = [];
        if (!isset($cache[$table])) {
            $cache[$table] = DB::connection('flat')->getSchemaBuilder()->getColumnListing($table);
        }

        return $cache[$table];
    }

    /**
     * Extract brand id from brands/{slug}/... by reading brand.json in same folder.
     *
     * @param string $relative
     * @return int|null
     */
    protected function brandIdFromPath($relative)
    {
        $dir = dirname($relative);
        $brand = $this->store->read($dir . '/brand.json');
        if ($brand && isset($brand['id'])) {
            return (int) $brand['id'];
        }

        return null;
    }

    /**
     * @param array $data
     * @return bool
     */
    protected function isList(array $data)
    {
        if ($data === []) {
            return true;
        }

        return array_keys($data) === range(0, count($data) - 1);
    }
}
