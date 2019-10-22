<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns;

class DateType extends AbstractType
{

    public function laravelMigrationColumn():string
    {
        return $this->getLaravelField('date');
    }

    public function thinkphpMigrationColumn():string
    {
        return $this->getThinkphpField('date', $this->columnOptions());
    }
}