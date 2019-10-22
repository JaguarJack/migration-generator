<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns;

class MultipointType extends AbstractType
{

    public function laravelMigrationColumn():string
    {
        return $this->getLaravelField('multipoint');
    }

    public function thinkphpMigrationColumn():string
    {
       return $this->getThinkphpField('multipoint', $this->columnOptions());
    }
}