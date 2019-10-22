<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Thinkphp;

class BinaryType extends AbstractType
{
    public function migrateColumn():string
    {
        return $this->getParsedField('binary', $this->columnOptions());
    }
}