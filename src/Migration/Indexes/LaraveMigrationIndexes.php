<?php

namespace JaguarJack\MigrateGenerator\Migration\Indexes;

use Doctrine\DBAL\Schema\Index;
use Doctrine\DBAL\Schema\Table;
use JaguarJack\MigrateGenerator\Migration\MigrationTrait;

class LaraveMigrationIndexes
{
    use MigrationTrait;

    protected $indexes;

    protected $table;

    public function __construct(Table $table)
    {
        $this->indexes = $table->getIndexes();

        $this->table = $table;
    }

    /**
     * parse indexes
     *
     * @time 2019年10月22日
     * @return string
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function parseIndexes()
    {
        $indexes = $this->getPrimaryKeys();

        foreach ($this->indexes as $index) {
            if (!$index->isPrimary()) {
                $indexes .= $this->parseIndex($index);
            }
        }

        return $indexes;
    }

    /**
     * parse index
     *
     * @param Index $index
     * @return string
     */
    protected function parseIndex(Index $index)
    {
        if ($index->isUnique()) {
            return $this->headString() . "unique('{$index->getColumns()[0]}', '{$index->getName()}');" . $this->eof();
        }

        if (\count($index->getColumns()) > 1) {
            $_column = '';
            foreach ($index->getColumns() as $column) {
                $_column .= "'{$column}',";
            }
            return $this->headString() . sprintf("index([%s], '%s');", trim($_column, ','), $index->getName()) . $this->eof();
        }


        return $this->headString() . sprintf("index('%s', '%s');", $index->getColumns()[0], $index->getName()) . $this->eof();
    }

    /**
     * get primary keys
     *
     * @return string
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    protected function getPrimaryKeys(): string
    {
        $primary = '';

        if (!isset($this->indexes['primary'])) {
            return $primary;
        }

        $columns = $this->indexes['primary']->getColumns();

        $this->removeAutoPrimaryKey($columns);

        if (!count($columns)) {
            return $primary;
        }

        if (count($columns) > 1) {
            $primary .= '[';
            foreach ($columns as $column) {
                $primary.= "'{$column}',";
            }
            $primary = trim($primary, ',');
            $primary .= ']';
        } else{
            $primary .= "'{$columns[0]}'";
        }


        return $this->headString() . sprintf('primary(%s);', $primary) . $this->eof();
    }

    /**
     * remove autoincrement primary key
     *
     * @param $columns
     * @throws \Doctrine\DBAL\Schema\SchemaException
     * @return void
     */
    protected function removeAutoPrimaryKey(&$columns): void
    {
        foreach ($columns as $key => $column) {
            if ($this->table->getColumn($column)->getAutoincrement()) {
                unset($columns[$key]);
            }
        }
    }
}
