<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns;

class EnumType extends AbstractType
{

    public function laravelMigrationColumn():string
    {
       return sprintf("enum('%s', %s)%s", $this->column->getName(), $this->getEnumValue(), $this->laravelOptions());
    }

    public function thinkphpMigrationColumn():string
    {
        return $this->getThinkphpField('enum', sprintf("['values' => %s]", $this->getEnumValue()));
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