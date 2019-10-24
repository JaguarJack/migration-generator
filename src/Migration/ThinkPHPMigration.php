<?php

namespace JaguarJack\MigrateGenerator\Migration;

use Doctrine\DBAL\Schema\Index;
use JaguarJack\MigrateGenerator\Migration\Indexes\ThinkphpMigrationIndexs;
use JaguarJack\MigrateGenerator\Types\DbType;
use think\helper\Str;

class ThinkPHPMigration extends AbstractMigration
{
    protected function getMigrationStub(): string
    {
        return 'TpMigration.stub';
    }

    /*
     *
     * @time 2019年10月21日
     * @throws \Doctrine\DBAL\DBALException
     * @return array
     */
    protected function getReplaceContent(): array
    {
        return [
            ucfirst(Str::camel($this->table['name'])),
            // table name
            $this->table['name'],
            // phinx table information
            sprintf("['engine' => '%s', 'collation' => '%s', 'comment' => '%s' %s %s]",
                $this->table['engine'], $this->table['collation'], $this->table['comment'], $this->getIndex()->getAutoIncrement(), $this->getIndex()->getPrimaryKeys()),

           '$table' . rtrim($this->getMigrationContent(), $this->eof())
        ];
    }

    /**
     * @return array
     */
    protected function replacedString(): array
    {
        return [
            '{MIGRATOR}','{TABLE}', '{TABLE_INFORMATION}', '{MIGRATION_CONTENT}'
        ];
    }

    /**
     *
     * @return string
     */
    protected function head(): string
    {
        return '->addColumn';
    }

    /**
     * 获取主
     *
     * @time 2019年10月24日
     * @return ThinkphpMigrationIndexs
     */
    protected function getIndex()
    {
        return new ThinkphpMigrationIndexs($this->_table);
    }


    protected function parseIndexes()
    {
        return $this->getIndex()->parseIndexes();
    }

}
