<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Thinkphp;

use JaguarJack\MigrateGenerator\Migration\Columns\AbstractType as Type;

abstract class AbstractType extends Type
{
    /**
     * Laravel frame temp
     *
     * @param $type
     * @param $options
     * @return string
     */
    protected function getParsedField($type, $options): string
    {
        return sprintf("('%s', '%s', %s)", $this->column->getName(), $type, $options);
    }

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
}