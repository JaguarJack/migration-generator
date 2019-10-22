<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Laravel;

class MediumIntType extends AbstractType
{

    public function migrateColumn():string
    {
        if ($this->column->getAutoincrement()) {
            return $this->getParsedField('mediumIncrements');
        }

        if ($this->column->getUnsigned()) {
            return $this->getParsedField('unsignedMediumInteger');
        }

        return $this->getParsedField('mediumInteger');
    }
}