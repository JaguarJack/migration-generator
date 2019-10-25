<?php

namespace JaguarJack\MigrateGenerator\Migration;

use Doctrine\DBAL\Schema\Index;
use Illuminate\Support\Str;
use JaguarJack\MigrateGenerator\Migration\Indexes\LaraveMigrationIndexes;

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
           explode('_', $this->table['collation'])[0],
           $this->table['collation'],
           $this->getTableComment(),
           $this->getMigrationContent(),
       ];
    }

    /**
     * replaced string
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

            sprintf('DB::statement("alter table `%s` comment '. "'%s'" .'");', $this->table['name'], $this->table['comment'])

            : '';
    }

    /**
     * parse head
     *
     * @return string
     */
    protected function head()
    {
        return '$table->';
    }

    /**
     *
     * @return string
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    protected function parseIndexes(): string
    {
       return str_replace($this->headString(), $this->head(), (new LaraveMigrationIndexes($this->_table))->parseIndexes());
    }
}
