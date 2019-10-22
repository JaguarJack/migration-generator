<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns;

class YearType extends AbstractType
{

    public function laravelMigrationColumn():string
    {
       return $this->getLaravelField('year');
    }

    public function thinkphpMigrationColumn():string
    {
        return $this->getThinkphpField('year', $this->columnOptions());

    }
}