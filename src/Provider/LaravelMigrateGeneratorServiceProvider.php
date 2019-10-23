<?php

namespace JaguarJack\MigrateGenerator\Provider;

use Illuminate\Support\ServiceProvider;
use JaguarJack\MigrateGenerator\Command\LaravelCommand;

class LaravelMigrateGeneratorServiceProvider extends ServiceProvider
{

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands([
            LaravelCommand::class
        ]);
    }
}
