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
     * @param string $generatePath
     * @return void
     * @throws \Exception
     * @throws \Doctrine\DBAL\DBALException
     * @throws Exceptions\EmptyInDatabaseException
     */
    public function generate(string $generatePath): void
    {
        $database = new Database($this->getDoctrineManage());

        $tables = $database->getAllTables();

        foreach ($tables as $key => $table) {
            $table->addOption('name', $table->getName());
            $table->addOption('origin', $database->getOriginTableInformation($table->getName()));
            $this->generateMigrationFile($generatePath, $table);
        }
    }

    /**
     * generate file
     *
     * @param string $generatePath
     * @param $table
     * @throws \Exception
     * @return void
     */
    protected function generateMigrationFile(string $generatePath, $table): void
    {
        $file = $generatePath . date('YmdHis') . random_int(0, 999999) . '_' . $table->getName() . '.php';

        file_put_contents($file, $this->getMigrationContent($table));
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
        return $this->getMigrationCreator()->setTable($table)->setFrame($this->frame)->output();
    }

    /**
     * get migration creator
     *
     * @return mixed
     */
    protected function getMigrationCreator()
    {
        return MigrationFactory::create($this->frame);
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
     * @return DocManager
     * @throws Exceptions\EmptyInDatabaseException
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function getDoctrineManage(): DocManager
    {
       return (new DocManager($this->frame));
    }

    /**
     * register new type
     *
     * @param array $types
     * @return bool
     */
    public function registerNewType(array $types): bool
    {
        return DocManager::addTypes($types);
    }

    /**
     * register new column parse
     *
     * @param array $columns
     * @return mixed
     */
    public function registerNewTypeParse(array $columns)
    {
        return $this->getMigrationCreator()->setExtendColumn($columns);
    }
}
