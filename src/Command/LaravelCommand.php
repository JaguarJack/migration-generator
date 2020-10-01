<?php

namespace JaguarJack\MigrateGenerator\Command;

use Illuminate\Console\Command;
use JaguarJack\MigrateGenerator\MigrateGenerator;
use JaguarJack\MigrateGenerator\Migration\LaravelMigrationForeignKeys;

class LaravelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migration:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate migration files if you never use';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $migrateGenerator = (new MigrateGenerator('laravel'));

        $tables = $migrateGenerator->getDatabase()->getAllTables();

        foreach ($tables as $key => $table) {

            file_put_contents(database_path( 'migrations/')  . date('Y_m_d_His') . '_' . $table->getName(). '.php' ,

                $migrateGenerator->getMigrationContent($table));

            $this->info(sprintf('%s table migration file generated', $table->getName()));
        }

        $this->foreignKeys($tables, database_path( 'migrations/'));
    }

    protected function foreignKeys($tables, $migrationsPath)
    {
        foreach ($tables as $key => $table) {
            $tableForeign = (new LaravelMigrationForeignKeys())->setTable($table);
            if ($tableForeign->hasForeignKeys()) {
                file_put_contents($migrationsPath . date('Y_m_d_His') . '_' . $table->getName() . '_foreign_keys.php',
                    $tableForeign->output());
            }
        }
    }
}
