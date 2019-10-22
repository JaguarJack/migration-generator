<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns;

class GeometryType extends AbstractType
{

    public function laravelMigrationColumn():string
    {
        return $this->getLaravelField('geometry');
    }

    public function thinkphpMigrationColumn():string
    {
        return $this->getThinkphpField('geometry', $this->columnOptions());
    }
}