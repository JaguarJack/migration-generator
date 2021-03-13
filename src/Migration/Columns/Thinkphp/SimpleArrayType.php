<?php
namespace JaguarJack\MigrateGenerator\Migration\Columns\Thinkphp;

class SimpleArrayType extends AbstractType
{
    public function migrateColumn():string
    {
        return $this->getParsedField('set', sprintf("['values' => %s]", $this->getSetValue()));
    }

    /**
     * get enum value
     *
     * @return array|string
     */
    protected function getSetValue()
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