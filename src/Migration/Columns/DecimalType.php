<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns;

class DecimalType extends AbstractType
{

    public function laravelMigrationColumn():string
    {
        return sprintf("decimal('%s', %d, %d)%s", $this->column->getName(), $this->column->getPrecision(), $this->column->getScale(), $this->laravelOptions());
    }

    public function thinkphpMigrationColumn():string
    {
        return $this->getThinkphpField('decimal', $this->columnOptions(0, $this->column->getPrecision(), $this->column->getScale()));
    }
}