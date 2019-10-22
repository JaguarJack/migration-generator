<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns;

class CharType extends AbstractType
{

    public function laravelMigrationColumn():string
    {
       return sprintf("char('%s', %d)%s", $this->column->getName(), $this->column->getLength(), $this->laravelOptions());
    }

    public function thinkphpMigrationColumn():string
    {
        return $this->getThinkphpField('char', $this->columnOptions($this->column->getLength()));
    }
}