<?php

declare(strict_types=1);

namespace Timatic\SDK\Providers;

use Illuminate\Support\ServiceProvider;
use Timatic\SDK\TimaticConnector;

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
        $this->app->singleton(TimaticConnector::class, function ($app) {
            $config = $app['config']->get('timatic', []);

            $timatic = new TimaticConnector();

            // Configure base URL if provided
            if (isset($config['base_url'])) {
                $timatic->baseUrl($config['base_url']);
            }

            // Add default headers if provided
            if (isset($config['headers']) && is_array($config['headers'])) {
                foreach ($config['headers'] as $key => $value) {
                    $timatic->headers()->add($key, $value);
                }
            }

            // Add authentication if provided
            if (isset($config['api_token'])) {
                $timatic->headers()->add('Authorization', 'Bearer ' . $config['api_token']);
            }

            return $timatic;
        });

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
