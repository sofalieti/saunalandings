<?php

namespace App\Console\Commands;

use App\FlatFile\Exporter;
use App\FlatFile\Index;
use Illuminate\Console\Command;

class FlatExportFromDb extends Command
{
    protected $signature = 'flat:export-from-db
                            {--dry-run : Count rows without writing files}
                            {--rebuild-index : Rebuild SQLite index after export}';

    protected $description = 'Export content tables from MySQL into content/ JSON files';

    public function handle(Exporter $exporter, Index $index)
    {
        $dryRun = (bool) $this->option('dry-run');
        $this->info($dryRun ? 'Dry run — no files will be written.' : 'Exporting content from DB to content/ ...');

        $summary = $exporter->export($dryRun);

        $this->table(['Table', 'Rows'], collect($summary)->map(function ($count, $table) {
            return [$table, $count];
        })->values()->all());

        if (!$dryRun && $this->option('rebuild-index')) {
            $this->info('Rebuilding SQLite index...');
            $counts = $index->rebuild();
            $this->table(['Table', 'Indexed'], collect($counts)->map(function ($count, $table) {
                return [$table, $count];
            })->values()->all());
        }

        $this->info('Done.');

        return 0;
    }
}
