<?php

namespace Timatic;

use Saloon\Contracts\Authenticator;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\HasPagination;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;
use Timatic\Foundation\Pagination\JsonApiPaginator;
use Timatic\Foundation\Responses\JsonApiResponse;

/**
 * Timatic API documentation
 *
 * Timatic API
 */
class TimaticConnector extends Connector implements HasPagination
{
    use AlwaysThrowOnErrors;

    public function __construct(
        protected ?string $bearerToken = null,
    ) {}

    public function resolveBaseUrl(): string
    {
        return config('timatic.base_url');
    }

    public function defaultAuth(): Authenticator
    {
        return new TokenAuthenticator($this->bearerToken, 'Bearer');
    }

    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/vnd.api+json',
            'Content-Type' => 'application/vnd.api+json',
        ];
    }

    public function resolveResponseClass(): string
    {
        return JsonApiResponse::class;
    }

    public function paginate(Request $request): JsonApiPaginator
    {
        return new JsonApiPaginator($this, $request);
    }
}
