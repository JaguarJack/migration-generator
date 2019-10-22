<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Thinkphp;

class StringType extends AbstractType
{
    public function migrateColumn():string
    {
        return $this->getParsedField('string', $this->columnOptions($this->column->getLength()));
    }
}