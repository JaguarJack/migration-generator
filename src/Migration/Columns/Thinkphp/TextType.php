<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Thinkphp;

use JaguarJack\MigrateGenerator\Types\DbType;

class TextType extends AbstractType
{
    public function migrateColumn():string
    {
        return  $this->getParsedField('text', $this->columnOptions($this->getTextType()));
    }

    /**
     * blob type
     *
     * @return mixed
     */
    protected function getTextType()
    {
        $types = [
            DbType::LENGTH => 'MysqlAdapter::TEXT_REGULAR',
            DbType::TINY_LENGTH => 'MysqlAdapter::TEXT_TINY',
            DbType::LONG_LENGTH => 'MysqlAdapter::TEXT_LONG',
        ];

        return $types[$this->column->getLength()] ?? 'MysqlAdapter::TEXT_MEDIUM';
    }

    /**
     * laravel text method
     *
     * @return mixed
     */
    protected function getTextMethod()
    {
        $methods = [
            DbType::LENGTH => 'text',
            DbType::TINY_LENGTH => 'tinyText',
            DbType::LONG_LENGTH => 'longText',
        ];

        return $methods[$this->column->getLength()] ?? 'mediumText';
    }
}
