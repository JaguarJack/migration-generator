<?php

namespace JaguarJack\MigrateGenerator\Migration;

use Doctrine\DBAL\Schema\Index;
use JaguarJack\MigrateGenerator\Migration\ForeignKeys\ThinkphpMigrationForeignKeys as ForeignKeys;
use JaguarJack\MigrateGenerator\Migration\Indexes\ThinkphpMigrationIndexs;
use JaguarJack\MigrateGenerator\Types\DbType;
use think\helper\Str;

class ThinkphpMigrationForeignKeys extends AbstractMigration
{
    protected function getMigrationStub(): string
    {
        return 'TpMigrationForeignKeys.stub';
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
            '$table' . rtrim($this->getMigrationContent(), $this->eof())
        ];
    }

    /**
     * @return array
     */
    protected function replacedString(): array
    {
        return [
            '{MIGRATOR}','{TABLE}', '{MIGRATION_CONTENT}'
        ];
    }

    /**
     *
     * @return string
     */
    protected function head(): string
    {
        return '->addColumn';
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
     * 获取外键内容
     *
     * @return mixed|string
     */
    public function getMigrationContent()
    {
        return $this->parseForeignKeys();
    }

    /**
     * 解析外键
     *
     * @return string
     */
    public function parseForeignKeys()
    {
        $foreignKeys = $this->_table->getForeignKeys();

        $s = '';

        foreach ($foreignKeys as $key => $foreignKeyConstraint) {
            list($delete, $update) = array_values($foreignKeyConstraint->getOptions());
            $s .= sprintf('->addForeignKey(%s, \'%s\', %s, [\'delete\' => \'%s\', \'update\' => \'%s\', \'constraint\' => \'%s\'])',
                var_export($foreignKeyConstraint->getLocalColumns(), true),
                $foreignKeyConstraint->getForeignTableName(),
                var_export($foreignKeyConstraint->getForeignColumns(), true),
                $delete ? : 'RESTRICT', $update ? : 'RESTRICT',
                $foreignKeyConstraint->getName()
            );
        }

        return $s;
    }
}
