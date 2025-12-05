<?php

declare(strict_types=1);

namespace Timatic\Pagination;

use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Paginator;

class JsonApiPaginator extends Paginator
{
    protected function isLastPage(Response $response): bool
    {
        return $response->json('links.next') === null;
    }

    protected function getPageItems(Response $response, Request $request): array
    {
        // Return the 'data' array from JSON:API response
        return $response->json('data', []);
    }

    protected function applyPagination(Request $request): Request
    {
        $request->query()->add('page[number]', $this->page);

        if (isset($this->perPageLimit)) {
            $request->query()->add('page[size]', $this->perPageLimit);
        }

        return $request;
    }
}
