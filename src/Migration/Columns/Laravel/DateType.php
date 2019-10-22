<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Laravel;

class DateType extends AbstractType
{
    public function migrateColumn():string
    {
        return $this->getParsedField('date');
    }

}