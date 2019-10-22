<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Laravel;

class MultiPolygonType extends AbstractType
{

    public function migrateColumn():string
    {
        return $this->getParsedField('multipolygon');
    }
}