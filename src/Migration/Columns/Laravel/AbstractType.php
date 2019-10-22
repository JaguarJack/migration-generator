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
        $options = '';

        if ($this->column->getUnsigned()) {
            $options .= '->unsigned();';
        }

        if ($this->column->getNotnull()) {
            $options .= '->nullable(false)';
            if ($this->isCanSetDefaultValue()) {
                $options .= "->default({$this->getDefault()})";
            }
        } else {
            $options .= '->nullable()';
        }

        $options .= "->comment('{$this->column->getComment()}');";

        return $options;
    }
}