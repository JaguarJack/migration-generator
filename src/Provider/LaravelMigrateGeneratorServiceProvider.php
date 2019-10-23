<?php

namespace JaguarJack\MigrateGenerator\Provider;

use App\Console\Commands\Create\LaravelCommand;
use Illuminate\Support\ServiceProvider;

class LaravelMigrateGeneratorServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands([
            LaravelCommand::class,
        ]);
    }
}
