<?php

namespace JaguarJack\MigrateGenerator\Migration\Indexes;

use Doctrine\DBAL\Schema\Index;
use Doctrine\DBAL\Schema\Table;
use JaguarJack\MigrateGenerator\Migration\MigrationTrait;

class ThinkphpMigrationIndexs
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
     * get autoincrement
     *
     * @return string
     */
    public function getAutoIncrement(): string
    {
        $autoIncrement = '';

        $autoField = $this->getAutoIncrementField();

        if ($autoField) {
            // list
            [$fieldName, $signed] = $autoField;
            $autoIncrement .= ",'id' => '{$fieldName}'";
            if ($signed) {
                $autoIncrement .= ",'signed' => true";
            }
        } else {
            $autoIncrement .= ",'id' => false";
        }

        return $autoIncrement ;
    }

    /**
     * get primary keys
     *
     * @return string
     */
    public function getPrimaryKeys(): string
    {
        $primary = '';

        if (!isset($this->indexes['primary'])) {
            return $primary;
        }

        foreach ($this->indexes['primary']->getColumns() as $column) {
            $primary .= "'{$column}',";
        }

        return $primary ? sprintf(",'primary_key' => [%s]", trim($primary, ',')) : '';
    }


    /**
     *
     * @return string
     */
    public function parseIndexes(): string
    {
        $indexes = '';
        foreach ($this->indexes as $index) {
            if (!$index->isPrimary()) {
                $indexes .= sprintf('->addIndex(%s)', $this->parseIndex($index)) . $this->eof();
            }
        }

        return $indexes;
    }

    /**
     * @param Index $index
     * @return string
     */
    protected function parseIndex(Index $index): string
    {
        $columns = $index->getColumns();

        $indexLengths = $index->getOption('lengths');

        // column
        $_columns = '';
        foreach ($columns as $column) {
            $_columns .= "'{$column}',";
        }
        $options = '';
        // limit
        $options .= count(array_filter($indexLengths)) ? $this->parseLimit($indexLengths, $columns) : '';
        // unique
        $options .= $index->isUnique() ? "'unique' => true," : '';
        // alias name
        $options .= $index->getName() ? "'name' => '{$index->getName()}'," : '';
        // type
        $options .= in_array('fulltext', $index->getFlags()) ? "'type' => 'fulltext'," : '';

        return sprintf('[%s], [%s]', trim($_columns, ','), trim($options, ','));
    }

    /**
     * parse limit
     *
     * @param $indexLengths
     * @param $columns
     * @return string
     */
    protected function parseLimit($indexLengths, $columns)
    {
        if (count($indexLengths) < 2 && $indexLengths[0]) {
            return  "'limit' => {$indexLengths['0']},";
        }

        $limit = "'limit' => [";
        foreach ($indexLengths as $key => $indexLength) {
            if ($indexLength) {
                $limit = "'$columns[$key]' => {$indexLength},";
            }
        }
        $limit .= '],';

        return $limit;
    }

    /**
     * get autoincrement field
     *
     * @return array|null
     */
    protected function getAutoIncrementField(): ?array
    {
        $columns = $this->table->getColumns();

        foreach ($columns as $key => $column) {
            if ($column->getAutoincrement()) {
                unset($columns[$key]);
                return [$column->getName(), $column->getUnsigned()];
            }
        }

        return null;
    }
}
