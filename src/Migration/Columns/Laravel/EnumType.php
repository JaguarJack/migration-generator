<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Laravel;

class EnumType extends AbstractType
{

    public function migrateColumn():string
    {
       return sprintf("enum('%s', %s)%s", $this->column->getName(), $this->getEnumValue(), $this->options());
    }

    /**
     * get enum value
     *
     * @return array|string
     */
    protected function getEnumValue()
    {
        $columnName = $this->column->getName();

        foreach ($this->originTableInfo as $column) {
            if ($column['Field'] === $columnName) {
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