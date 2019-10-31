<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Laravel;

use JaguarJack\MigrateGenerator\Migration\Columns\AbstractType as Type;

abstract class AbstractType extends Type
{
    /**
     * Laravel frame temp
     *
     * @param $method
     * @return string
     */
    protected function getParsedField($method): string
    {
        return sprintf("%s('%s')%s", $method, $this->column->getName(), $this->options());
    }

    /**
     * laravel options
     *
     * @return string
     */
    protected function options(): string
    {
        return $this->getNull() . $this->default() . $this->getComment();
    }

    /**
     * get unsigned
     *
     * @return string
     */
    protected function getUnsigned(): ?string
    {
        if ($this->column->getUnsigned()) {
            return '->unsigned()';
        }
    }

    /**
     * get null
     *
     * @return string
     */
    protected function getNull(): string
    {
        return $this->column->getNotnull() ? '->nullable(false)' : '->nullable()';
    }

    /**
     * default 方法
     *
     * @time 2019年10月31日
     * @return string
     */
    protected function default()
    {
        if (!$this->isCanSetDefaultValue() && !$this->column->getAutoincrement()) {
            if ($this->column->getNotnull() && $this->getDefault() == 'null') {
                return '';
            }

            return "->default({$this->getDefault()})";
        }

        return '';
    }

    /**
     * get comment
     *
     * @return string
     */
    protected function getComment(): string
    {
       return "->comment('{$this->column->getComment()}');";
    }

}
