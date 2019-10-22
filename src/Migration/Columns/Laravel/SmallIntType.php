<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Laravel;

class SmallIntType extends AbstractType
{

    public function migrateColumn():string
    {
        if ($this->column->getAutoincrement()) {
            return $this->getParsedField('smallIncrements');
        }

        if ($this->column->getUnsigned()) {
            return $this->getParsedField('unsignedSmallInteger');
        }

        return $this->getParsedField('smallInteger');
    }
}