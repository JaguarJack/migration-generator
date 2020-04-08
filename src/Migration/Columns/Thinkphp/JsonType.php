<?php
namespace JaguarJack\MigrateGenerator\Migration\Columns\Thinkphp;

class JsonType extends AbstractType
{
    public function migrateColumn():string
    {
        return $this->getParsedField('json', $this->columnOptions());
    }
}