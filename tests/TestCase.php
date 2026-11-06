<?php

declare(strict_types=1);

namespace Timatic\Tests;

use Dotenv\Dotenv;
use Orchestra\Testbench\TestCase as Orchestra;
use Saloon\Laravel\SaloonServiceProvider;
use Spatie\LaravelData\LaravelDataServiceProvider;
use Timatic\Providers\TimaticServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            LaravelDataServiceProvider::class,
            SaloonServiceProvider::class,
            TimaticServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        if (file_exists(dirname(__DIR__).'/.env')) {
            (Dotenv::createImmutable(dirname(__DIR__), '.env'))->load();
        }

        $app['config']->set('timatic.base_url', env('TIMATIC_BASE_URL', 'https://api.tenant.timatic.app'));
        $app['config']->set('timatic.api_token', env('TIMATIC_API_TOKEN'));
    }
}
