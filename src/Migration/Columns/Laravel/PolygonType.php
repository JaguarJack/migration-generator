<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Laravel;

class PolygonType extends AbstractType
{

    public function migrateColumn():string
    {
       return $this->getParsedField('polygon');
    }

}