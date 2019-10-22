<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Laravel;

class BinaryType extends AbstractType
{

    public function migrateColumn():string
    {
       return $this->getParsedField('binary');
    }

}