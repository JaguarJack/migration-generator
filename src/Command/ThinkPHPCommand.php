<?php

declare(strict_types=1);

namespace JaguarJack\MigrateGenerator\Command;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use JaguarJack\MigrateGenerator\MigrateGenerator;

class ThinkPHPCommand extends Command
{
    protected $manger = null;

    protected function configure()
    {
        // 指令配置
        $this->setName('generator')
            ->setDescription('the app\command\generator command');
    }

    protected function execute(Input $input, Output $output)
    {
        $migrateGenerator = new MigrateGenerator('laravel');

        $migrateGenerator->generate();

        $output->info('generate all table successful');
    }
}

