<?php

namespace Timatic;

use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\HasPagination;
use Timatic\Pagination\JsonApiPaginator;
use Timatic\Responses\TimaticResponse;

/**
 * timatic-api
 */
class TimaticConnector extends Connector implements HasPagination
{
    protected function defaultHeaders(): array
    {
        $headers = [
            'Accept' => 'application/vnd.api+json',
            'Content-Type' => 'application/vnd.api+json',
        ];

        if ($token = config('timatic.api_token')) {
            $headers['Authorization'] = "Bearer {$token}";
        }

        return $headers;
    }

    public function resolveResponseClass(): string
    {
        return TimaticResponse::class;
    }

    public function paginate(Request $request): JsonApiPaginator
    {
        return new JsonApiPaginator($this, $request);
    }

    public function __construct() {}

    public function resolveBaseUrl(): string
    {
        return config('timatic.base_url');
    }
}
