<?php

namespace JaguarJack\MigrateGenerator\Provider;

use JaguarJack\MigrateGenerator\Command\ThinkPHPCommand;
use think\Service;

class ThinkphpMigrateGeneratorService extends Service
{
    public function boot()
    {
        $this->commands([
            ThinkPHPCommand::class,
        ]);
    }
}