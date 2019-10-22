<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Thinkphp;

class BooleanType extends AbstractType
{
    public function migrateColumn():string
    {
        return $this->getParsedField('boolean', $this->columnOptions());
    }
}