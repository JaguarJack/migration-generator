<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns;

class MultiPolygonType extends AbstractType
{

    public function laravelMigrationColumn():string
    {
        return $this->getLaravelField('multipolygon');
    }

    public function thinkphpMigrationColumn():string
    {
        return $this->getThinkphpField('multipolygon', $this->columnOptions());
    }
}