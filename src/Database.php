<?php

namespace JaguarJack\MigrateGenerator;


class Database
{
    protected $doctrineManager;

    protected $doctrineConnection;

    /**
     * Database constructor.
     * @param DocManager $docManager
     * @throws Exceptions\EmptyInDatabaseException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function __construct(DocManager $docManager)
    {
        $this->doctrineManager = $docManager->getDoctrineManage();

        $this->doctrineConnection = $docManager->getDoctrineConnection();
    }

    /**
     * get all tables
     *
     * @return \Doctrine\DBAL\Schema\Table[]
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getAllTables(): array
    {
        $tables = $this->doctrineManager->listTables();

        foreach ($tables as &$table) {
            $table->addOption('name', $table->getName());
            $table->addOption('origin', $this->getOriginTableInformation($table->getName()));
        }

        return $tables;
    }

    /**
     * get databases
     *
     * @return string[]
     */
    public function getDatabases(): array
    {
        return $this->doctrineManager->listDatabases();
    }

    /**
     * get table detail
     *
     * @param $tableName
     * @return mixed[]
     */
    public function getTableDetail($tableName): array
    {
        return $this->doctrineManager->listTableDetails($tableName)->getOptions();
    }

    /**
     * get table indexes
     *
     * @param $tableName
     * @return \Doctrine\DBAL\Schema\Index[]
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getTableIndexes($tableName): array
    {
        return $this->doctrineManager->listTableIndexes($tableName);
    }

    /**
     * get table columns
     *
     * @param $tableName
     * @return \Doctrine\DBAL\Schema\Column[]
     */
    public function getTableColumns($tableName): array
    {
        return $this->doctrineManager->listTableColumns($tableName);
    }

    /**
     * 获取原始信息
     *
     * @param $tableName
     * @throws \Doctrine\DBAL\DBALException
     * @return mixed[]
     */
    public function getOriginTableInformation($tableName): array
    {
        return $this->doctrineConnection->fetchAll($this->doctrineManager->getDatabasePlatform()->getListTableColumnsSQL($tableName));
    }

    /**
     *
     * @param $method
     * @param $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
       return call_user_func_array([$this->doctrineManager, $method], $arguments);
    }
}
