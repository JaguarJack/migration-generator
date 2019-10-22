<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns;

class BigIntType extends AbstractType
{

    public function laravelMigrationColumn():string
    {
        if ($this->column->getAutoincrement()) {
            return $this->getLaravelField('bigIncrements');
        }

        if ($this->column->getUnsigned()) {
            return $this->getLaravelField('unsignedBigInteger');
        }

        return $this->getLaravelField('bigInteger');
    }

    public function thinkphpMigrationColumn():string
    {
        return $this->getThinkphpField('integer', $this->columnOptions('MysqlAdapter::INT_BIG'));
    }
}