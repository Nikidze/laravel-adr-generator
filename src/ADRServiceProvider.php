<?php

namespace Nikidze\ADRGenerator;

use Illuminate\Support\ServiceProvider;

class ADRServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Nikidze\ADRGenerator\Console\Commands\Generate::class,
            ]);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
    }
}
