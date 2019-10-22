<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Laravel;

class DecimalType extends AbstractType
{
    public function migrateColumn():string
    {
        return sprintf("decimal('%s', %d, %d)%s", $this->column->getName(), $this->column->getPrecision(), $this->column->getScale(), $this->options());
    }
}