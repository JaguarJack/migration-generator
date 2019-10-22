<?php

namespace JaguarJack\MigrateGenerator\Migration;

use Doctrine\DBAL\Schema\Index;
use think\helper\Str;
use Illuminate\Support\Str as LaravelStr;

class LaravelMigration extends AbstractMigration
{

    /**
     * stub name
     *
     * @return string
     */
    protected function getMigrationStub(): string
    {
        return 'LaravelMigration.stub';
    }

    /**
     *
     * @throws \Doctrine\DBAL\DBALException
     * @return array
     */
    protected function getReplaceContent(): array
    {
       return [
           ucfirst(Str::camel($this->table['name'])),
           $this->table['name'],
           $this->table['engine'],
           explode(',', $this->table['collation'])[0],
           $this->table['collation'],
           $this->getTableComment(),
           $this->getMigrationContent(),
       ];
    }

    /**
     * 被替换的字符
     *
     * @return array
     */
    protected function replacedString(): array
    {
        return ['{CLASS}', '{TABLE}', '{ENGINE}', '{CHARSET}', '{COLLATION}', '{TABLE_COMMENT}', '{MIGRATION_CONTENT}'];
    }

    /**
     * get table comment
     * `
     * @return string
     */
    protected function getTableComment()
    {
        return $this->table['comment'] ?

            sprintf('DB::statement("alter table `%s` comment '. "'{$this->table['name']}'" .'");', $this->table['name'], $this->table['comment'])

            : '';
    }

    /**
     * parse head
     *
     * @time 2019年10月21日
     * @return string
     */
    protected function head()
    {
        return '$table->';
    }

    /**
     * parse indexes
     *
     * @time 2019年10月22日
     * @return string
     */
    protected function parseIndexes()
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
            return $this->head() . "unique('{$index->getColumns()[0]}', '{$index->getName()}', '{$index->getName()}');" . $this->eof();
        }

        if (count($index->getColumns()) > 1) {
            $_column = '';
            foreach ($index->getColumns() as $column) {
                $_column .= "'{$column}',";
            }
            return $this->head() . sprintf("index([%s], '%s');", trim($_column, ','), $index->getName()) . $this->eof();
        }


        return $this->head() . sprintf("index('%s', '%s');", $index->getColumns()[0], $index->getName()) . $this->eof();
    }

    /**
     * get primary keys
     *
     * @return string
     */
    protected function getPrimaryKeys(): string
    {
        $primary = '';

        $columns = $this->indexes['primary']->getColumns();

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


        return $this->head() . sprintf('primary(%s);', $primary) . $this->eof();
    }
}