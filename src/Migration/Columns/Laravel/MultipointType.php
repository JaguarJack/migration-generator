<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Laravel;

class MultipointType extends AbstractType
{

    public function migrateColumn():string
    {
        return $this->getParsedField('multipoint');
    }
}