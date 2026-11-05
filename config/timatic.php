<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Timatic API Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL for the API. You can override this if you're using
    | a different environment or a local development setup.
    |
    */

    'base_url' => env('TIMATIC_BASE_URL', 'https://api.tenant.timatic.app'),

    /*
    |--------------------------------------------------------------------------
    | Timatic API Token
    |--------------------------------------------------------------------------
    |
    | Your API authentication token. This will be sent as a Bearer
    | token in the Authorization header.
    |
    */

    'api_token' => env('TIMATIC_API_TOKEN'),

];
