<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns;

class DoubleType extends AbstractType
{

    public function laravelMigrationColumn():string
    {
        return sprintf("double('%s', %d, %d)%s", $this->column->getName(), $this->column->getPrecision(), $this->column->getScale(), $this->laravelOptions());
    }


    public function thinkphpMigrationColumn():string
    {
        /**
         * phinx unsupported so instead of decimal
         *
         */
        return $this->getThinkphpField('decimal', $this->columnOptions(0, $this->column->getPrecision(), $this->column->getScale()));
    }
}