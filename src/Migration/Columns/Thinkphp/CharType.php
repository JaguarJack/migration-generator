<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Thinkphp;

class CharType extends AbstractType
{
    public function migrateColumn():string
    {
        return $this->getParsedField('char', $this->columnOptions($this->column->getLength()));
    }
}