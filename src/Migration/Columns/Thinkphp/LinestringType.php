<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Thinkphp;

class LinestringType extends AbstractType
{
    public function migrateColumn():string
    {
        return $this->getParsedField('linestring', $this->columnOptions());
    }
}