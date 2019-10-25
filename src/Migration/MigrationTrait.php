<?php

namespace JaguarJack\MigrateGenerator\Migration;

use JaguarJack\MigrateGenerator\Exceptions\UnSupportedFrameException;

trait MigrationTrait
{
    /**
     * parse column
     *
     * @time 2019年10月21日
     * @return mixed
     * @throws \Exception
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function parseColumn()
    {
        $className = $this->getTypeClassName();

        $migrationColumnClass = $this->getExtendColumn($className);

        if (!$migrationColumnClass) {
            $migrationColumnClass = '\\JaguarJack\\MigrateGenerator\\Migration\\Columns\\' .
                $this->frame . '\\' . $className;

            if (!class_exists($migrationColumnClass)) {
                throw new \Exception(sprintf('%s not found', $migrationColumnClass));
            }

        }

        $migrationColumn = new $migrationColumnClass($this->column, $this->table['origin']);

        return $migrationColumn->migrateColumn();
    }

    /**
     *
     * @return mixed
     */
    protected function getTypeClassName()
    {
        $class = explode('\\', get_class($this->column->getType()));

        return array_pop($class);
    }

    /**
     * replace
     *
     * @time 2019年10月24日
     * @return string
     */
    protected function headString(): string
    {
        return '{head}';
    }


    /**
     *
     * @param $className
     * @return bool
     */
    protected function getExtendColumn($className): bool
    {
        if (isset(static::$extendColumn[$className])) {
            return static::$extendColumn[$className][$this->frame];
        }

        return false;
    }


    /**
     * eof
     *
     * @return string
     */
    protected function eof(): string
    {
        return "\r\n\t\t\t";
    }

    /**
     * get autoincrement field
     *
     * @return array|null
     */
    protected function getAutoIncrementField(): ?array
    {
        foreach ($this->columns as $key => $column) {
            if ($column->getAutoincrement()) {
                unset($this->columns[$key]);
                return [$column->getName(), $column->getUnsigned()];
            }
        }

        return null;
    }
}
