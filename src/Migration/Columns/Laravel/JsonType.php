<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Laravel;

class JsonType extends AbstractType
{

    public function migrateColumn():string
    {
        return $this->getParsedField('json');
    }
}