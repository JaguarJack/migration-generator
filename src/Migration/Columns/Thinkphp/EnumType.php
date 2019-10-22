<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Thinkphp;

class EnumType extends AbstractType
{
    public function migrateColumn():string
    {
        return $this->getParsedField('enum', sprintf("['values' => %s]", $this->getEnumValue()));
    }

    /**
     * get enum value
     *
     * @return array|string
     */
    protected function getEnumValue()
    {
        $originTable = $this->originTableInfo;

        $columnName = $this->column->getName();

        foreach ($originTable as $column) {
            if ($column['Field'] == $columnName) {
                preg_match('/\((.*?)\)/', $column['Type'], $match);
                break;
            }
        }

        if (!empty($match)) {
            return sprintf('[%s]', $match[1]);
        }

        return '[]';
    }
}