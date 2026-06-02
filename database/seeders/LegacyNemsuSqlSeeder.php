<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use RuntimeException;

class LegacyNemsuSqlSeeder extends Seeder
{
    /**
     * @var array<int, string>
     */
    private array $legacyTables = [
        'bac_matters',
        'banners',
        'campuses',
        'colleges',
        'downloadable_files',
        'events',
        'galleries',
        'gallery_photos',
        'job_opportunities',
        'news',
        'news_views',
        'offices',
        'programs',
    ];

    /**
     * Seed legacy website content from the SQL dump without recreating tables.
     */
    public function run(): void
    {
        $sqlPath = env('LEGACY_NEMSU_SQL_PATH');

        if (! is_file($sqlPath)) {
            throw new RuntimeException("Legacy SQL dump not found at [{$sqlPath}].");
        }

        $sql = file_get_contents($sqlPath);

        if ($sql === false) {
            throw new RuntimeException("Unable to read legacy SQL dump at [{$sqlPath}].");
        }

        Schema::disableForeignKeyConstraints();

        try {
            foreach ($this->legacyTables as $table) {
                if (! Schema::hasTable($table)) {
                    $this->command?->warn("Skipping [{$table}] because the table does not exist.");

                    continue;
                }

                if (DB::table($table)->exists()) {
                    $this->command?->info("Skipping [{$table}] because it already has rows.");

                    continue;
                }

                $insertStatements = $this->insertStatementsFor($sql, $table);

                if ($insertStatements === []) {
                    $this->command?->info("No dump rows found for [{$table}].");

                    continue;
                }

                foreach ($insertStatements as $statement) {
                    DB::unprepared($statement);
                }

                $this->command?->info("Seeded [{$table}] with ".DB::table($table)->count().' rows.');
            }
        } finally {
            Schema::enableForeignKeyConstraints();
        }
    }

    /**
     * @return array<int, string>
     */
    private function insertStatementsFor(string $sql, string $table): array
    {
        $pattern = '/INSERT INTO `'.preg_quote($table, '/').'` .*?;\R/s';

        if (preg_match_all($pattern, $sql, $matches) !== false) {
            return $matches[0];
        }

        return [];
    }
}
