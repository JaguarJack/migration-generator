<?php

namespace JaguarJack\MigrateGenerator\Migration\Columns\Thinkphp;

use JaguarJack\MigrateGenerator\Migration\Columns\AbstractType as Type;

abstract class AbstractType extends Type
{
    /**
     * thinkphp frame temp
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
     * @param $precision
     * @param $scale
     * @return string
     */
    protected function columnOptions($limit = 0, $precision = null,  $scale = null): string
    {
        $options = '';

        if ($limit) {
            $options .= sprintf("'limit' => %s,", $limit);
        }

        if ($precision !== null) {
            $options .= "'precision' => {$precision},";
        }

        if ($scale !== null) {
            $options .= "'scale' => {$scale},";
        }

        return '[' . $options . $this->getNull() . $this->getSigned() . $this->getComment() . ']';
    }

    /**
     * comment
     *
     * @return string
     */
    protected function getComment()
    {
        return sprintf("'comment' => '%s',", $this->column->getComment());
    }

    /**
     * get signed
     *
     * @return string
     */
    protected function getSigned()
    {
        return sprintf("'signed' => %s,", !$this->column->getUnsigned() ? 'true' : 'false');
    }

    /**
     * get null
     *
     * @return string
     */
    protected function getNull()
    {
        if ($this->column->getNotnull()) {
            $null = "'null' => false,";

            if (!$this->isCanSetDefaultValue()) {
                $null .= sprintf("'default' => %s,", $this->getDefault());
            }

            return $null;
        }

        return  "'null' => true,";
    }
}