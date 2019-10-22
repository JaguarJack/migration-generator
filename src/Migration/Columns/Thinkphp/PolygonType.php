<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Thinkphp;

class PolygonType extends AbstractType
{
    public function migrateColumn():string
    {
       return $this->getParsedField('polygon', $this->columnOptions());
    }
}