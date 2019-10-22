<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns;

class LinestringType extends AbstractType
{

    public function laravelMigrationColumn():string
    {
        return $this->getLaravelField('linestring');
    }

    public function thinkphpMigrationColumn():string
    {
        return $this->getThinkphpField('linestring', $this->columnOptions());
    }
}