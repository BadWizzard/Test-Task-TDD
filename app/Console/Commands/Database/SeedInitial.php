<?php

namespace App\Console\Commands\Database;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\TabularDataReader;
use Throwable;

class SeedInitial extends Command
{
    protected const PATH_TO_DATA = '/database/seeders/data';

    protected const PATH_TO_CONFIG = '/database/seeders/config/seed-initial.json';

    protected const STMT = "INSERT INTO %s (%s) VALUES %s;";

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:seed-initial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initial seed from csv files.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Seed started.');

        $tables = $this->getTables();

        $tableName = '';

        try {
            DB::beginTransaction();

            foreach ($tables as $tableName) {
                $records = $this->getRecordsByTableName($tableName);

                if (empty($records)) {
                    continue;
                }

                foreach ($records as $record) {
                    $this->insertRecord($tableName, $record);
                }

                $this->info('Seed completed for table ' . $tableName . '.');
            }

            DB::commit();

            $this->info('Seeds have been committed.');
            return 0;
        } catch (Throwable $throwable) {
            DB::rollBack();
            $this->error('Failed at table ' . ($tableName ?? ''));
            $this->error(substr($throwable->getMessage(), 0, 500));
            return $throwable->getCode();
        }
    }

    /**
     * @return array
     */
    protected function getTables(): array
    {
        $config = file_get_contents(base_path() . static::PATH_TO_CONFIG);

        $config = json_decode($config, true);

        return $config['seeders'];
    }

    /**
     * @param string $tableName
     * @return TabularDataReader|array
     * @throws Exception
     */
    protected function getRecordsByTableName(string $tableName)
    {
        $pathToSeed = base_path() . static::PATH_TO_DATA . '/' . $tableName . '.csv';

        if (!file_exists($pathToSeed)) {
            return [];
        }

        $csv = Reader::createFromPath($pathToSeed, 'r');
        $csv->setHeaderOffset(0);

        $stmt = Statement::create();

        return $stmt->process($csv);
    }

    /**
     * @param string $tableName
     * @param array $record
     * @return void
     */
    protected function insertRecord(string $tableName, array $record): void
    {
        $headers = [];
        $values = [];

        foreach ($record as $key => $value) {
            if ($value !== '') {
                $headers[] = $key;
                $values[] = $value;
            }
        }

        $bindValues = array_map(fn($data) => '?', $values);

        $insertStmt = sprintf(
            static::STMT,
            $tableName,
            implode(',', $headers),
            '(' . implode(',', $bindValues) . ')'
        );

        $query = DB::raw($insertStmt);

        DB::insert($query, $values);
    }
}
