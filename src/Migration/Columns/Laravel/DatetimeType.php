<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Laravel;

class DatetimeType extends AbstractType
{
    public function migrateColumn():string
    {
       return $this->getParsedField('datetime');
    }

}