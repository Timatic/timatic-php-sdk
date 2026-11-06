<?php

declare(strict_types=1);

namespace Timatic\Tests\Foundation\Fixtures;

use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\HasPagination;
use Timatic\Foundation\Pagination\JsonApiPaginator;
use Timatic\Foundation\Responses\JsonApiResponse;

class FixtureConnector extends Connector implements HasPagination
{
    public function resolveBaseUrl(): string
    {
        return 'https://api.test';
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
