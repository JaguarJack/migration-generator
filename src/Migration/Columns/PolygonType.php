<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns;

class PolygonType extends AbstractType
{

    public function laravelMigrationColumn():string
    {
       return $this->getLaravelField('polygon');
    }

    public function thinkphpMigrationColumn():string
    {
       return $this->getThinkphpField('polygon', $this->columnOptions());
    }
}