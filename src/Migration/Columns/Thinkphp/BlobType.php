<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Thinkphp;

use JaguarJack\MigrateGenerator\Types\DbType;

class BlobType extends AbstractType
{
    public function migrateColumn():string
    {
        return $this->getParsedField('blob', $this->columnOptions($this->getBlobType()));
    }


    /**
     * blob type
     *
     * @return mixed
     */
    protected function getBlobType()
    {
        return [
            DbType::LENGTH => 'MysqlAdapter::BLOB_REGULAR',
            DbType::TINY_LENGTH => 'MysqlAdapter::BLOB_TINY',
            DbType::MEDIUM_LENGTH => 'MysqlAdapter::BLOB_MEDIUM',
            DbType::LONG_LENGTH => 'MysqlAdapter::BLOB_LONG',
        ][$this->column->getLength()];
    }
}