<?php

namespace JaguarJack\MigrateGenerator;

use JaguarJack\MigrateGenerator\Migration\MigrationFactory;

class MigrateGenerator
{
    protected $frame;

    /**
     * MigrateGenerator constructor.
     * @param string $frame
     */
    public function __construct(string $frame = 'thinkphp')
    {
        $this->frame = strtolower($frame);
    }

    /**
     *
     * @time 2019年10月21日
     * @throws Exceptions\EmptyInDatabaseException
     * @throws \Doctrine\DBAL\DBALException
     * @return void
     */
    public function generate(): void
    {
        $database = new Database($this->getDoctrineManage());

        $tables = $database->getAllTables();

        foreach ($tables as $key => $table) {
            $table->addOption('name', $table->getName());
            $table->addOption('origin', $database->getOriginTableInformation($table->getName()));
            file_put_contents(app()->getRootPath().'/database/migrations/' . date('YmdHis') . "{$key}_" . $table->getName() . '.php',
            $this->getMigrationContent($table));
        }
    }

    /**
     * get migration content
     *
     * @time 2019年10月21日
     * @param $table
     * @return mixed
     */
    public function getMigrationContent($table)
    {
        return MigrationFactory::create($this->frame)->setTable($table)->output();
    }

    /**
     * get database
     *
     * @throws Exceptions\EmptyInDatabaseException
     * @throws \Doctrine\DBAL\DBALException
     * @return Database
     */
    public function getDatabase(): Database
    {
        return new Database($this->getDoctrineManage());
    }

    /**
     * get doctrine manage
     *
     * @time 2019年10月21日
     * @throws \Doctrine\DBAL\DBALException
     * @return DocManager
     */
    protected function getDoctrineManage()
    {
       return (new DocManager($this->frame));
    }
}
