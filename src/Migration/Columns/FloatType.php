<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns;

class FloatType extends AbstractType
{

    public function laravelMigrationColumn():string
    {
        return sprintf("float('%s', %d, %d)%s", $this->column->getName(), $this->column->getPrecision(), $this->column->getScale(), $this->laravelOptions());
    }

    public function thinkphpMigrationColumn():string
    {
        return $this->getThinkphpField('double', $this->columnOptions(0, $this->column->getPrecision(), $this->column->getScale()));
    }
}