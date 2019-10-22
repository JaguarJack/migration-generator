<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Laravel;

use JaguarJack\MigrateGenerator\Types\DbType;

class BlobType extends AbstractType
{

    public function migrateColumn():string
    {
        return $this->getParsedField('binary');
    }

}