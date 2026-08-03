<?php

namespace App\Console\Commands;

use App\FlatFile\Store;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class FlatVerify extends Command
{
    protected $signature = 'flat:verify';

    protected $description = 'Compare MySQL content row counts vs content/ files vs SQLite index';

    public function handle(Store $store)
    {
        $tables = config('flat.tables');
        $rows = [];

        foreach ($tables as $table) {
            $mysql = null;
            try {
                if (Schema::connection(config('database.default'))->hasTable($table)) {
                    $mysql = DB::connection()->table($table)->count();
                }
            } catch (\Exception $e) {
                $mysql = 'err';
            }

            $files = $this->countFiles($store, $table);

            $sqlite = null;
            try {
                if (File::exists(config('flat.sqlite_path'))
                    && Schema::connection('flat')->hasTable($table)
                ) {
                    $sqlite = DB::connection('flat')->table($table)->count();
                }
            } catch (\Exception $e) {
                $sqlite = 'err';
            }

            $rows[] = [$table, $mysql, $files, $sqlite];
        }

        $this->table(['Table', 'MySQL', 'Files*', 'SQLite'], $rows);
        $this->line('* Files = approximate file/aggregate counts (FAQ/states counted as items).');
        $this->line('FLAT_CONTENT=' . (config('flat.enabled') ? 'true' : 'false'));

        return 0;
    }

    /**
     * @param Store  $store
     * @param string $table
     * @return int|string
     */
    protected function countFiles(Store $store, $table)
    {
        try {
            if ($table === 'brand_faq_items') {
                $n = 0;
                foreach ($store->glob('brands/*/faq.json') as $path) {
                    $data = $store->read($path);
                    $n += is_array($data) ? count($data) : 0;
                }
                return $n;
            }
            if ($table === 'brand_states') {
                $n = 0;
                foreach ($store->glob('brands/*/states.json') as $path) {
                    $data = $store->read($path);
                    $n += is_array($data) ? count($data) : 0;
                }
                return $n;
            }
            if ($table === 'brand_model_line') {
                $n = 0;
                foreach ($store->glob('brands/*/model_lines.json') as $path) {
                    $data = $store->read($path);
                    $n += is_array($data) ? count($data) : 0;
                }
                return $n;
            }
            if ($table === 'category_brands') {
                $data = $store->read('category_brands.json');
                return is_array($data) ? count($data) : 0;
            }
            if ($table === 'form_fields') {
                $n = 0;
                foreach ($store->glob('forms/*.json') as $path) {
                    $data = $store->read($path);
                    $n += (is_array($data) && isset($data['fields'])) ? count($data['fields']) : 0;
                }
                return $n;
            }
            if ($table === 'custom_forms') {
                return count($store->glob('forms/*.json'));
            }
            if ($table === 'brands') {
                return count($store->glob('brands/*/brand.json'));
            }

            $pattern = \App\FlatFile\Paths::globForTable($table);
            if (!$pattern) {
                return '-';
            }

            return count($store->glob($pattern));
        } catch (\Exception $e) {
            return 'err';
        }
    }
}
