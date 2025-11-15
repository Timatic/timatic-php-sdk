<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Timatic API Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL for the Timatic API. You can override this if you're using
    | a different environment or a local development setup.
    |
    */

    'base_url' => env('TIMATIC_BASE_URL', 'https://api.app.timatic.test'),

    /*
    |--------------------------------------------------------------------------
    | Timatic API Token
    |--------------------------------------------------------------------------
    |
    | Your Timatic API authentication token. This will be sent as a Bearer
    | token in the Authorization header.
    |
    */

    'api_token' => env('TIMATIC_API_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | Default Headers
    |--------------------------------------------------------------------------
    |
    | The SDK automatically includes the following headers:
    | - Accept: application/vnd.api+json
    | - Content-Type: application/vnd.api+json
    | - Authorization: Bearer {api_token} (if api_token is set)
    |
    | This configuration is reserved for future use if you need to add
    | additional custom headers beyond the defaults.
    |
    */

];
