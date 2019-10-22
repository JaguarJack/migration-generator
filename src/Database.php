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
     * @time 2019年10月20日
     * @return \Doctrine\DBAL\Schema\Table[]
     */
    public function getAllTables(): array
    {
        return $this->doctrineManager->listTables();
    }

    /**
     * get databases
     *
     * @time 2019年10月20日
     * @return string[]
     */
    public function getDatabases(): array
    {
        return $this->doctrineManager->listDatabases();
    }

    /**
     * get table detail
     *
     * @time 2019年10月20日
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
     * @time 2019年10月20日
     * @param $tableName
     * @return \Doctrine\DBAL\Schema\Index[]
     */
    public function getTableIndexes($tableName): array
    {
        return $this->doctrineManager->listTableIndexes($tableName);
    }

    /**
     * get table columns
     *
     * @time 2019年10月20日
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
     * @time 2019年10月21日
     * @param $tableName
     * @throws \Doctrine\DBAL\DBALException
     * @return mixed[]
     */
    public function getOriginTableInformation($tableName): array
    {
        return $this->doctrineConnection->fetchAll($this->doctrineManager->getDatabasePlatform()->getListTableColumnsSQL($tableName));
    }
}
