<?php
namespace JaguarJack\MigrateGenerator\Migration;

use Doctrine\DBAL\Schema\Index;
use Illuminate\Support\Str;
use JaguarJack\MigrateGenerator\Migration\ForeignKeys\LaravelMigrationForeignKeys as ForeignKeys;
use JaguarJack\MigrateGenerator\Migration\Indexes\ThinkphpMigrationIndexs;
use JaguarJack\MigrateGenerator\Types\DbType;

class LaravelMigrationForeignKeys extends AbstractMigration
{
    protected function getMigrationStub(): string
    {
        return 'LaravelMigrationForeignKeys.stub';
    }

    /*
     * replace content
     *
     * @throws \Doctrine\DBAL\DBALException
     * @return array
     */
    protected function getReplaceContent(): array
    {
        return [
            ucfirst(Str::camel($this->table['name'])) . 'ForeignKeys',
            // table name
            $this->table['name'],
            // phinx table information
            rtrim($this->getMigrationContent(), $this->eof())
        ];
    }

    /**
     * @return array
     */
    protected function replacedString(): array
    {
        return [
            '{CLASS}','{TABLE}', '{MIGRATION_CONTENT}'
        ];
    }

    /**
     * get migration content
     *
     * @return mixed|string
     */
    public function getMigrationContent()
    {
        return $this->parseForeignKeys();
    }

    /**
     * 是否有外键
     *
     * @return bool
     */
    public function hasForeignKeys()
    {
        return count($this->_table->getForeignKeys()) ? true : false;
    }

    /**
     * 解析外键
     *
     * @return string
     */
    protected function parseForeignKeys()
    {
        $foreignKeys = $this->_table->getForeignKeys();

        $s = '';

        foreach ($foreignKeys as $key => $foreignKeyConstraint) {
            list($delete, $update) = array_values($foreignKeyConstraint->getOptions());
            $s .= sprintf('$table->foreign(\'%s\')
                           ->references(\'%s\')
                           ->on(\'%s\')
                           ->onDelete(\'%s\')
                           ->onUpdate(\'%s\');'.PHP_EOL,
                $foreignKeyConstraint->getLocalColumns()[0],
                $foreignKeyConstraint->getForeignColumns()[0],
                $foreignKeyConstraint->getLocalTableName(),
                strtolower($delete ? : 'RESTRICT'), strtolower($update ? : 'RESTRICT')
            );
        }

        return $s;
    }
}
