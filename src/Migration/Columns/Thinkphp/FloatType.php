<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Thinkphp;

class FloatType extends AbstractType
{
    public function migrateColumn():string
    {
        return $this->getParsedField('double', $this->columnOptions(0, $this->column->getPrecision(), $this->column->getScale()));
    }
}