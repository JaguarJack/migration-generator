<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Laravel;

class LinestringType extends AbstractType
{

    public function migrateColumn():string
    {
        return $this->getParsedField('linestring');
    }
}