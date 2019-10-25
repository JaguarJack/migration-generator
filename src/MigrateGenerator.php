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
        file_put_contents($generatePath . date('Y_m_d_His') . $table->getName() . '.php', $this->getMigrationContent($table));
    }

    /**
     * get migration content
     *
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
