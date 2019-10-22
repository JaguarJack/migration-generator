<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Thinkphp;

class MediumIntType extends AbstractType
{
    public function migrateColumn():string
    {
        return $this->getParsedField('integer', $this->columnOptions('MysqlAdapter::INT_MEDIUM'));
    }
}