<?php

namespace App\FlatFile;

/**
 * Trait for content Eloquent models.
 *
 * When FLAT_CONTENT=true:
 * - queries use the `flat` SQLite connection (built from content/ files)
 * - saved/deleted events sync JSON files under content/
 *
 * When false: normal MySQL behaviour (no-op).
 */
trait UsesFlatFiles
{
    /**
     * Boot the trait.
     */
    public static function bootUsesFlatFiles()
    {
        static::saved(function ($model) {
            if (!config('flat.enabled')) {
                return;
            }
            app(Writer::class)->writeModel($model);
        });

        static::deleted(function ($model) {
            if (!config('flat.enabled')) {
                return;
            }
            app(Writer::class)->deleteModel($model);
        });
    }

    /**
     * Switch connection when flat content mode is enabled.
     *
     * @return string|null
     */
    public function getConnectionName()
    {
        if (config('flat.enabled')) {
            return 'flat';
        }

        return property_exists($this, 'connection') ? $this->connection : null;
    }
}
