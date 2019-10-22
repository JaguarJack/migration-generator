<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Thinkphp;

class MultipointType extends AbstractType
{
    public function migrateColumn():string
    {
       return $this->getParsedField('multipoint', $this->columnOptions());
    }
}