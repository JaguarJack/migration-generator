<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns;

class SmallIntType extends AbstractType
{

    public function laravelMigrationColumn():string
    {
        if ($this->column->getAutoincrement()) {
            return $this->getLaravelField('smallIncrements');
        }

        if ($this->column->getUnsigned()) {
            return $this->getLaravelField('unsignedSmallInteger');
        }

        return $this->getLaravelField('smallInteger');
    }

    public function thinkphpMigrationColumn():string
    {
        return $this->getThinkphpField('integer', $this->columnOptions('MysqlAdapter::INT_SMALL'));
    }
}