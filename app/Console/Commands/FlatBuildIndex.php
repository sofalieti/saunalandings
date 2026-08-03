<?php

namespace App\Console\Commands;

use App\FlatFile\Index;
use Illuminate\Console\Command;

class FlatBuildIndex extends Command
{
    protected $signature = 'flat:build-index';

    protected $description = 'Rebuild storage/flat/content.sqlite from content/ JSON files';

    public function handle(Index $index)
    {
        $this->info('Rebuilding flat content SQLite index...');
        $counts = $index->rebuild();
        $this->table(['Table', 'Rows'], collect($counts)->map(function ($count, $table) {
            return [$table, $count];
        })->values()->all());
        $this->info('Index written to: ' . config('flat.sqlite_path'));

        return 0;
    }
}
