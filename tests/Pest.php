<?php

use Timatic\SDK\TimaticConnector;

// Mock config helper for tests
if (! function_exists('config')) {
    function config(string $key, $default = null)
    {
        $config = [
            'timatic.base_url' => 'https://api.app.timatic.test',
            'timatic.api_token' => null,
        ];

        return $config[$key] ?? $default;
    }
}

uses()->beforeEach(function () {
    $this->timatic = new TimaticConnector;
})->in(__DIR__);
