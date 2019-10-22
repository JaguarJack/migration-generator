<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Laravel;

class BigIntType extends AbstractType
{
    public function migrateColumn():string
    {
        if ($this->column->getAutoincrement()) {
            return $this->getParsedField('bigIncrements');
        }

        if ($this->column->getUnsigned()) {
            return $this->getParsedField('unsignedBigInteger');
        }

        return $this->getParsedField('bigInteger');
    }
}