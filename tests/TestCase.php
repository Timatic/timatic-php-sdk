<?php

namespace Timatic\Tests;

use Dotenv\Dotenv;
use Orchestra\Testbench\TestCase as Orchestra;
use Saloon\Laravel\SaloonServiceProvider;
use Timatic\Providers\TimaticServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            SaloonServiceProvider::class,
            TimaticServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        // Load .env into the environment if it exists
        if (file_exists(dirname(__DIR__).'/.env')) {
            (Dotenv::createImmutable(dirname(__DIR__), '.env'))->load();
        }

        // Set config values for testing
        $app['config']->set('timatic.base_url', env('TIMATIC_BASE_URL', 'https://api.app.timatic.test'));
        $app['config']->set('timatic.api_token', env('TIMATIC_API_TOKEN'));
    }
}
