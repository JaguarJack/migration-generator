<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Laravel;

class IntegerType extends AbstractType
{

    public function migrateColumn():string
    {
        if ($this->column->getAutoincrement()) {
            return $this->getParsedField('increments');
        }

        if ($this->column->getUnsigned()) {
            return $this->getParsedField('unsignedInteger');
        }

        return $this->getParsedField('integer');
    }
}