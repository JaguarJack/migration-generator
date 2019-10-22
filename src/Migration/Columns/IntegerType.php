<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns;

class IntegerType extends AbstractType
{

    public function laravelMigrationColumn():string
    {
        if ($this->column->getAutoincrement()) {
            return $this->getLaravelField('increments');
        }

        if ($this->column->getUnsigned()) {
            return $this->getLaravelField('unsignedInteger');
        }

        return $this->getLaravelField('integer');
    }

    public function thinkphpMigrationColumn():string
    {
        return $this->getThinkphpField('integer', $this->columnOptions('MysqlAdapter::INT_REGULAR'));
    }
}