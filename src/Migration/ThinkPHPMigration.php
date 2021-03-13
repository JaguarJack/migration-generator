<?php

namespace JaguarJack\MigrateGenerator\Migration;

use Doctrine\DBAL\Schema\Index;
use JaguarJack\MigrateGenerator\Migration\ForeignKeys\ThinkphpMigrationForeignKeys;
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
     * replace content
     *
     * @throws \Doctrine\DBAL\DBALException
     * @return array
     */
    protected function getReplaceContent(): array
    {
        $this->removeAutoincrementColumn();

        return [
            ucfirst(Str::camel($this->table['name'])),
            // table name
            $this->table['name'],
            // phinx table information
            sprintf("['engine' => '%s', 'collation' => '%s', 'comment' => '%s' %s %s]",
                $this->table['engine'], $this->table['collation'], $this->table['comment'], $this->getIndexParse()->getAutoIncrement(), $this->getIndexParse()->getPrimaryKeys()),

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
     * get index parse
     *
     * @return ThinkphpMigrationIndexs
     */
    protected function getIndexParse()
    {
        return new ThinkphpMigrationIndexs($this->_table);
    }

    /**
     * parse index
     *
     * @return string
     */
    protected function parseIndexes()
    {
        return $this->getIndexParse()->parseIndexes();
    }

    protected function parseForeignKeys()
    {
        return (new ThinkphpMigrationForeignKeys($this->_table))->parseForeignIndexes();
    }

    /**
     * remove autoincrement column
     *
     * @return void
     */
    protected function removeAutoincrementColumn()
    {
        foreach ($this->columns as $k => $column) {
            if ($column->getAutoincrement()) {
                unset($this->columns[$k]);
                break;
            }
        }
    }

}
