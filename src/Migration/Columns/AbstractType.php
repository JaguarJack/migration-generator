<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns;

use Doctrine\DBAL\Schema\Column;

abstract class AbstractType
{
    /**
     * @var Column
     */
    protected $column;

    /**
     * @var array
     */
    protected $originTableInfo;

    public function __construct(Column $column, array $originTableInfo)
    {
        $this->column = $column;

        $this->originTableInfo = $originTableInfo;
    }

    /**
     * @return string
     */
    abstract public function migrateColumn(): string ;


    /**
     *
     * @time 2019年10月22日
     * @return int|string|null
     */
    protected function getDefault()
    {
        $default = $this->column->getDefault();

        if ($default === null) {
            return 'null';
        }

        if (is_numeric($default)) {
            return (int)$default;
        }

        return "'{$default}'";
    }

    /**
     * @return bool
     */
    protected function isCanSetDefaultValue(): bool
    {
        return in_array($this->column->getType()->getName(), $this->cantHaveDefaultType()) && !$this->column->getDefault() ? true : false;
    }

    /**
     *
     * @return array
     */
    protected function cantHaveDefaultType(): array
    {
        return [
            'blob', 'text', 'date', 'json', 'geometry', 'multigeometry', 'timestamp',
        ];
    }
}
