<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns;

class DatetimeType extends AbstractType
{

    public function laravelMigrationColumn():string
    {
       return $this->getLaravelField('datetime');
    }

    public function thinkphpMigrationColumn():string
    {
       return $this->getThinkphpField('datetime', $this->columnOptions());
    }
}