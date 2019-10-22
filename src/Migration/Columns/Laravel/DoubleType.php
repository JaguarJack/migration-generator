<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Laravel;

class DoubleType extends AbstractType
{

    public function migrateColumn():string
    {
        return sprintf("double('%s', %d, %d)%s", $this->column->getName(), $this->column->getPrecision(), $this->column->getScale(), $this->options());
    }
}