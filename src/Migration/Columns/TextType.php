<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns;

use JaguarJack\MigrateGenerator\Types\DbType;

class TextType extends AbstractType
{

    public function laravelMigrationColumn():string
    {
        return $this->getLaravelField($this->getTextMethod());
    }

    public function thinkphpMigrationColumn():string
    {
        return  $this->getThinkphpField('text', $this->columnOptions($this->getTextType()));
    }

    /**
     * blob type
     *
     * @return mixed
     */
    protected function getTextType()
    {
        return [
            DbType::LENGTH => 'MysqlAdapter::TEXT_REGULAR',
            DbType::TINY_LENGTH => 'MysqlAdapter::TEXT_TINY',
            DbType::MEDIUM_LENGTH => 'MysqlAdapter::TEXT_MEDIUM',
            DbType::LONG_LENGTH => 'MysqlAdapter::TEXT_LONG',
        ][$this->column->getLength()];
    }

    /**
     * laravel text method
     *
     * @return mixed
     */
    protected function getTextMethod()
    {
        return [
            DbType::LENGTH => 'text',
            DbType::TINY_LENGTH => 'tinyText',
            DbType::MEDIUM_LENGTH => 'mediumText',
            DbType::LONG_LENGTH => 'longText',
        ][$this->column->getLength()];
    }
}