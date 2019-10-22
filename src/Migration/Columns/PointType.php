<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns;

class PointType extends AbstractType
{

    public function laravelMigrationColumn():string
    {
        return $this->getLaravelField('point');
    }

    public function thinkphpMigrationColumn():string
    {
       return $this->getThinkphpField('point', $this->columnOptions());
    }
}