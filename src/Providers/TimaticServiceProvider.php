<?php

declare(strict_types=1);

namespace Timatic\Providers;

use Illuminate\Support\ServiceProvider;
use Timatic\TimaticConnector;

class TimaticServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/timatic.php',
            'timatic'
        );

        $this->app->singleton(TimaticConnector::class, fn () => new TimaticConnector(
            config('timatic.api_token'),
        ));

        $this->app->alias(TimaticConnector::class, 'timatic');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../../config/timatic.php' => config_path('timatic.php'),
        ], 'timatic-config');
    }
}
