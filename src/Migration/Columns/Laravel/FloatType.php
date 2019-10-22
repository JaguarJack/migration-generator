<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Laravel;

class FloatType extends AbstractType
{

    public function migrateColumn():string
    {
        return sprintf("float('%s', %d, %d)%s", $this->column->getName(), $this->column->getPrecision(), $this->column->getScale(), $this->options());
    }
}