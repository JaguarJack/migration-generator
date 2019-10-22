<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Thinkphp;

class DoubleType extends AbstractType
{
    public function migrateColumn():string
    {
        /**
         * phinx unsupported so instead of decimal
         *
         */
        return $this->getParsedField('decimal', $this->columnOptions(0, $this->column->getPrecision(), $this->column->getScale()));
    }
}