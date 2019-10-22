<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Thinkphp;

class TimestampType extends AbstractType
{

    protected const CURRENT_TIMESTAMP = 'CURRENT_TIMESTAMP';

    public function migrateColumn():string
    {
        $this->column->setDefault($this->isSetCurrentTimestamp() ? self::CURRENT_TIMESTAMP : '');

        return $this->getParsedField('timestamp', $this->columnOptions());
    }

    /**
     * is set current timestamp
     *
     * @time 2019年10月21日
     * @return bool
     */
    protected function isSetCurrentTimestamp(): bool
    {
        $originTable = $this->originTableInfo;

        $columnName = $this->column->getName();

        $isSet = false;

        foreach ($originTable as $column) {
            if ($column['Field'] == $columnName) {
                if (strpos($column['Default'], self::CURRENT_TIMESTAMP) !== false || strpos($column['Extra'], self::CURRENT_TIMESTAMP)) {
                    $isSet = true;
                }
                break;
            }
        }

        return $isSet;
    }
}