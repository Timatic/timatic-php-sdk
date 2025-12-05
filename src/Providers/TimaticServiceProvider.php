<?php

declare(strict_types=1);

namespace Timatic\Providers;

use Illuminate\Support\ServiceProvider;
use Timatic\TimaticConnector;

class TimaticServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Merge config
        $this->mergeConfigFrom(
            __DIR__.'/../../config/timatic.php',
            'timatic'
        );

        // Register TimaticConnector as singleton
        $this->app->singleton(TimaticConnector::class);

        // Register alias
        $this->app->alias(TimaticConnector::class, 'timatic');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Publish config
        $this->publishes([
            __DIR__.'/../../config/timatic.php' => config_path('timatic.php'),
        ], 'timatic-config');
    }
}
