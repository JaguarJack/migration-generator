<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Laravel;

class TimestampType extends AbstractType
{

    protected const CURRENT_TIMESTAMP = 'CURRENT_TIMESTAMP';

    public function migrateColumn():string
    {
          return $this->getParsedField($this->isSetCurrentTimestamp() ? 'timestampTz' : 'timestamp');
    }

    /**
     * is set current timestamp
     *
     * @time 2019年10月21日
     * @return bool
     */
    protected function isSetCurrentTimestamp(): bool
    {
        $columnName = $this->column->getName();

        $isSet = false;

        foreach ($this->originTableInfo as $column) {
            if ($column['Field'] === $columnName) {
                if (strpos($column['Default'], self::CURRENT_TIMESTAMP) !== false || strpos($column['Extra'], self::CURRENT_TIMESTAMP)) {
                    $isSet = true;
                }
                break;
            }
        }

        return $isSet;
    }
}