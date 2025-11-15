<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\SDK\Requests\Budget\GetBudgets;

it('paginates through multiple pages using JSON:API pagination', function () {
    // Create mock responses for 3 pages
    $mockClient = new MockClient([
        // Page 1 - has next link
        MockResponse::make([
            'data' => [
                ['type' => 'budgets', 'id' => '1', 'attributes' => ['title' => 'Budget 1']],
                ['type' => 'budgets', 'id' => '2', 'attributes' => ['title' => 'Budget 2']],
            ],
            'links' => [
                'next' => 'https://api.app.timatic.test/budgets?page[number]=2&page[size]=2',
                'first' => 'https://api.app.timatic.test/budgets?page[number]=1&page[size]=2',
            ],
        ]),
        // Page 2 - has next link
        MockResponse::make([
            'data' => [
                ['type' => 'budgets', 'id' => '3', 'attributes' => ['title' => 'Budget 3']],
                ['type' => 'budgets', 'id' => '4', 'attributes' => ['title' => 'Budget 4']],
            ],
            'links' => [
                'next' => 'https://api.app.timatic.test/budgets?page[number]=3&page[size]=2',
                'prev' => 'https://api.app.timatic.test/budgets?page[number]=1&page[size]=2',
            ],
        ]),
        // Page 3 - last page, no next link
        MockResponse::make([
            'data' => [
                ['type' => 'budgets', 'id' => '5', 'attributes' => ['title' => 'Budget 5']],
            ],
            'links' => [
                'next' => null,
                'prev' => 'https://api.app.timatic.test/budgets?page[number]=2&page[size]=2',
            ],
        ]),
    ]);

    $timatic = $this->timatic->withMockClient($mockClient);

    // Create paginator
    $paginator = $timatic->paginate(new GetBudgets);
    $paginator->setPerPageLimit(2);

    // Collect all items
    $allBudgets = [];
    foreach ($paginator->items() as $budget) {
        $allBudgets[] = $budget;
    }

    // Should have collected 5 budgets total across 3 pages
    expect($allBudgets)->toHaveCount(5);

    // Verify all 3 requests were made
    expect($mockClient->getRecordedRequests())->toHaveCount(3);

    // Verify first request has correct pagination params
    $firstRequest = $mockClient->getRecordedRequests()[0];
    expect($firstRequest->query()->get('page[number]'))->toBe(1);
    expect($firstRequest->query()->get('page[size]'))->toBe(2);

    // Verify second request incremented page number
    $secondRequest = $mockClient->getRecordedRequests()[1];
    expect($secondRequest->query()->get('page[number]'))->toBe(2);
    expect($secondRequest->query()->get('page[size]'))->toBe(2);

    // Verify third request
    $thirdRequest = $mockClient->getRecordedRequests()[2];
    expect($thirdRequest->query()->get('page[number]'))->toBe(3);
});

it('stops pagination when links.next is null', function () {
    $mockClient = new MockClient([
        // Single page - no next link
        MockResponse::make([
            'data' => [
                ['type' => 'budgets', 'id' => '1', 'attributes' => ['title' => 'Budget 1']],
            ],
            'links' => [
                'next' => null,
                'first' => 'https://api.app.timatic.test/budgets?page[number]=1',
            ],
        ]),
    ]);

    $timatic = $this->timatic->withMockClient($mockClient);
    $paginator = $timatic->paginate(new GetBudgets);

    $allBudgets = [];
    foreach ($paginator->items() as $budget) {
        $allBudgets[] = $budget;
    }

    // Should only have 1 budget
    expect($allBudgets)->toHaveCount(1);

    // Should only have made 1 request
    expect($mockClient->getRecordedRequests())->toHaveCount(1);
});

it('request implements Paginatable interface', function () {
    $request = new GetBudgets;

    expect($request)->toBeInstanceOf(Paginatable::class);
});
