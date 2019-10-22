<?php

namespace JaguarJack\MigrateGenerator\Migration;

use Doctrine\DBAL\Schema\Index;
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
                $this->table['engine'], $this->table['collation'], $this->table['comment'], $this->getAutoIncrement(), $this->getPrimaryKeys()),

           $this->head() . $this->getMigrationContent()
        ];
    }

    /**
     * get autoincrement
     *
     * @return string
     */
    protected function getAutoIncrement(): string
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
    protected function getPrimaryKeys(): string
    {
        $primary = '';

        foreach ($this->indexes['primary']->getColumns() as $column) {
            $primary .= "'{$column}',";
        }

        return $primary ? sprintf(",'primary_key' => [%s]", trim($primary, ',')) : '';
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
     *
     * @return string
     */
    protected function parseIndexes(): string
    {
        $indexes = '';
        foreach ($this->indexes as $index) {
            if (!$index->isPrimary()) {
                $indexes .= sprintf("->addIndex(%s)\r\n", $this->parseIndex($index));
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
}
