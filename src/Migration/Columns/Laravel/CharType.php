<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Laravel;

class CharType extends AbstractType
{

    public function migrateColumn():string
    {
       return sprintf("char('%s', %d)%s", $this->column->getName(), $this->column->getLength(), $this->options());
    }
}