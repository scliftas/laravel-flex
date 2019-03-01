<?php

namespace Shaunclift\Flex;

use Illuminate\Support\ServiceProvider;

class FlexServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/flex.php' => config_path('flex.php'),
        ]);

        $this->loadRoutesFrom(__DIR__ . '/Http/routes/routes.php');
    }

    /**
     * Register the application services
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Flex::class, function () {
            return new Flex();
        });

        $this->app->alias(Flex::class, 'flex');
    }
}
