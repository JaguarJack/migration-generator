<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns;

class BooleanType extends AbstractType
{

    public function laravelMigrationColumn():string
    {
        return $this->getLaravelField('boolean');
    }

    public function thinkphpMigrationColumn():string
    {
        return $this->getThinkphpField('boolean', $this->columnOptions());
    }
}