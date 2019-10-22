<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Thinkphp;

class DecimalType extends AbstractType
{
    public function migrateColumn():string
    {
        return $this->getParsedField('decimal', $this->columnOptions(0, $this->column->getPrecision(), $this->column->getScale()));
    }
}