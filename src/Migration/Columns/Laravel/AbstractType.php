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
        return $this->getNull() . $this->getComment();
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
        if ($this->column->getNotnull()) {
            $null = '->nullable(false)';
            if ($this->isCanSetDefaultValue()) {
                $default = $this->getDefault();
                $null .= '->default('.(is_numeric($default) ? $default : "'{$default}'"). ')';
            }
            return $null;
        }

        return '->nullable()';
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
