<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns;

class GeometrycollectionType extends AbstractType
{

    public function laravelMigrationColumn():string
    {
        return $this->getLaravelField('geometrycollection');
    }

    public function thinkphpMigrationColumn():string
    {
        return $this->getThinkphpField('geometrycollection', $this->columnOptions());
    }
}