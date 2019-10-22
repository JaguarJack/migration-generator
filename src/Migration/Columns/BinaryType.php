<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns;

class BinaryType extends AbstractType
{

    public function laravelMigrationColumn():string
    {
       return $this->getLaravelField('binary');
    }

    public function thinkphpMigrationColumn():string
    {
        return $this->getThinkphpField('binary', $this->columnOptions());
    }
}