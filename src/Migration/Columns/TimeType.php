<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns;

class TimeType extends AbstractType
{

    public function laravelMigrationColumn():string
    {
        return $this->getLaravelField('time');
    }

    public function thinkphpMigrationColumn():string
    {
       return $this->getThinkphpField('time', $this->columnOptions());
    }
}