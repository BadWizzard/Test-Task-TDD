<?php

namespace App\Console\Commands\Database;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

class DropTables extends Command
{
    protected const PATH_TO_DUMP = '/database/initial/drop-tables.sql';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:drop-tables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop all existed tables.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $this->info('Running drop tables.');

            $path = base_path() . static::PATH_TO_DUMP;

            $sql = file_get_contents($path);

            DB::unprepared($sql);

            $this->info('Tables have been dropped successfully.');
            return 0;
        } catch (Throwable $throwable) {
            $this->error('Drop tables process has been failed. ' . $throwable->getMessage());
            return $throwable->getCode();
        }
    }
}
