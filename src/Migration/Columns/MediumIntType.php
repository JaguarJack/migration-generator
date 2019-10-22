<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns;

class MediumIntType extends AbstractType
{

    public function laravelMigrationColumn():string
    {
        if ($this->column->getAutoincrement()) {
            return $this->getLaravelField('mediumIncrements');
        }

        if ($this->column->getUnsigned()) {
            return $this->getLaravelField('unsignedMediumInteger');
        }

        return $this->getLaravelField('mediumInteger');
    }

    public function thinkphpMigrationColumn():string
    {
        return $this->getThinkphpField('integer', $this->columnOptions('MysqlAdapter::INT_MEDIUM'));
    }
}