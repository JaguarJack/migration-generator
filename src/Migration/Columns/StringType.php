<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns;

class StringType extends AbstractType
{

    public function laravelMigrationColumn():string
    {
        return sprintf("string('{$this->column->getName()}', %d)%s", (int)$this->column->getLength(), $this->laravelOptions());
    }

    public function thinkphpMigrationColumn():string
    {
        return $this->getThinkphpField('string', $this->columnOptions($this->column->getLength()));
    }
}