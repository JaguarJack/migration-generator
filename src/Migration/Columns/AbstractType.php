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
    abstract public function laravelMigrationColumn(): string ;

    /**
     * @return string
     */
    abstract public function thinkphpMigrationColumn(): string;

    /**
     * get column options
     *
     * @param int $limit
     * @param int $precision
     * @param int $scale
     * @return string
     */
    protected function columnOptions($limit = 0, int $precision = 0, int $scale = 0): string
    {
        $options = '[';

        if ($limit) {
            $options .= sprintf("'limit' => %s,", $limit);
        }

        if ($precision) {
            $options .= "'precision' => {$precision},";
        }

        if ($scale) {
            $options .= "'scale' => {$scale},";
        }

        if ($this->column->getNotnull()) {
            $options .= "'null' => false,";

            if (!$this->isCanSetDefaultValue()) {
                $options .= sprintf("'default' => %s,", $this->getDefault());
            }
        } else {
            $options .= "'null' => true,";
        }

        $options .= "'comment' => '{$this->column->getComment()}',";

        $options .= "'signed' => " . ($this->column->getUnsigned() ? 'true' : 'false') . ',';

        $options .= ']';

        return $options;
    }

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

    /**
     * thinkphp frame temp
     *
     * @param $type
     * @param $options
     * @return string
     */
    protected function getThinkphpField($type, $options): string
    {
        return sprintf("('%s', '%s', %s)", $this->column->getName(), $type, $options);
    }

    /**
     * Laravel frame temp
     *
     * @param $method
     * @return string
     */
    protected function getLaravelField($method): string
    {
        return sprintf("%s('%s')%s", $method, $this->column->getName(), $this->laravelOptions());
    }

    /**
     * laravel options
     *
     * @return string
     */
    protected function laravelOptions(): string
    {
        $options = '';

        if ($this->column->getUnsigned()) {
            $options .= '->unsigned();';
        }

        if ($this->column->getNotnull()) {
            $options .= '->nullable(false)';
            if ($this->isCanSetDefaultValue()) {
                $options .= "->default({$this->getDefault()})";
            }
        } else {
            $options .= '->nullable()';
        }

        $options .= "->comment('{$this->column->getComment()}');";

        return $options;
    }
}
