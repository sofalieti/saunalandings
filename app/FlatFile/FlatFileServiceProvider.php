<?php

namespace App\FlatFile;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class FlatFileServiceProvider extends ServiceProvider
{
    /**
     * Register bindings.
     */
    public function register()
    {
        $this->mergeConfigFrom(base_path('config/flat.php'), 'flat');

        $this->app->singleton(Store::class, function () {
            return new Store();
        });

        $this->app->singleton(Schema::class, function () {
            return new Schema();
        });

        $this->app->singleton(Index::class, function ($app) {
            return new Index($app->make(Store::class), $app->make(Schema::class));
        });

        $this->app->singleton(Exporter::class, function ($app) {
            return new Exporter($app->make(Store::class));
        });

        $this->app->singleton(Writer::class, function ($app) {
            return new Writer($app->make(Store::class));
        });

        // Register flat SQLite connection
        $this->app->resolving('db', function ($db) {
            $config = $this->app['config'];
            $connections = $config->get('database.connections', []);
            $connections['flat'] = [
                'driver' => 'sqlite',
                'database' => $config->get('flat.sqlite_path', storage_path('flat/content.sqlite')),
                'prefix' => '',
                'foreign_key_constraints' => false,
            ];
            $config->set('database.connections', $connections);
        });
    }

    /**
     * Bootstrap.
     */
    public function boot()
    {
        if (!$this->app->runningInConsole()) {
            // Ensure SQLite exists when flat mode is on (avoid fatal on missing file)
            if (config('flat.enabled')) {
                $path = config('flat.sqlite_path');
                if (!File::exists($path)) {
                    try {
                        app(Index::class)->rebuild();
                    } catch (\Exception $e) {
                        // Leave error visible in logs; site may 500 until flat:build-index
                        \Log::error('Flat content index missing and rebuild failed: ' . $e->getMessage());
                    }
                }
            }
        }
    }
}
