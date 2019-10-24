<?php

namespace JaguarJack\MigrateGenerator\Migration;

use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Type as DoctrineType;
use JaguarJack\MigrateGenerator\Types\DbType;

abstract class AbstractMigration
{
    use MigrationTrait;

    /**
     * @var array
     */
    protected $table;

    /**
     * @var Table
     */
    protected $_table;

    /**
     * @var Column[]
     */
    protected $columns;

    /**
     * @var Column
     */
    protected $column;

    /**
     * @var Type
     */
    protected $columnType;

    /**
     * @var string
     */
    protected $frame;
    /**
     * @var array
     */
    protected $indexes;

    /**
     * @var array
     */
    protected static $extendColumn = [];

    /**
     * @return string
     */
    abstract protected function getMigrationStub(): string ;

    /**
     * @return array
     */
    abstract protected function getReplaceContent(): array ;

    /**
     * @return array
     */
    abstract protected function replacedString(): array ;
    /**
     * get the path of migrate stub
     *
     * @time 2019年10月20日
     * @return string
     */
    public function getMigrateStubContent(): string
    {
        return file_get_contents(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . $this->getMigrationStub());
    }

    /**
     * set table info
     *
     * @param $table
     * @return $this
     */
    public function setTable(Table $table): self
    {
        $this->_table = $table;

        $this->table = $table->getOptions();

        $this->columns = $table->getColumns();

        $this->indexes = $table->getIndexes();

        return $this;
    }

    /**
     * set frame
     *
     * @param string $frame
     * @return $this
     */
    public function setFrame(string $frame): self
    {
        $this->frame = ucfirst($frame);

        return $this;
    }


    /**
     * get migration content
     *
     * @return mixed
     * @throws
     */
     public function getMigrationContent()
    {
        $content = '';

        foreach ($this->columns as $column) {

            $this->column = $column;

            $this->columnType = $column->getType();

            $content .= $this->head() . sprintf($this->parseColumn(), $column->getName()) . $this->eof();
        }

        $content .= $this->parseIndexes();

        return $content;
    }

    /**
     * output
     *
     * @return mixed
     */
    public function output()
    {
        return str_replace($this->replacedString(), $this->getReplaceContent(), $this->getMigrateStubContent());
    }

    /**
     * register new column type parse
     *
     * @param $columns
     * @return bool
     */
    public function setExtendColumn(array $columns): bool
    {
        static::$extendColumn = array_merge(static::$extendColumn, $columns);

        return true;
    }
}
