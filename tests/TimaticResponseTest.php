<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Timatic\SDK\Requests\Budget\GetBudgets;
use Timatic\SDK\Responses\TimaticResponse;

it('returns first item from collection response', function () {
    $mockClient = new MockClient([
        MockResponse::make([
            'data' => [
                ['type' => 'budgets', 'id' => '1', 'attributes' => ['title' => 'Budget 1']],
                ['type' => 'budgets', 'id' => '2', 'attributes' => ['title' => 'Budget 2']],
            ],
        ]),
    ]);

    $response = $this->timatic
        ->withMockClient($mockClient)
        ->send(new GetBudgets);

    expect($response)->toBeInstanceOf(TimaticResponse::class);

    $firstItem = $response->firstItem();
    expect($firstItem)->toBeArray();
    expect($firstItem['id'])->toBe('1');
    expect($firstItem['attributes']['title'])->toBe('Budget 1');
});

it('returns single item for non-collection response', function () {
    $mockClient = new MockClient([
        MockResponse::make([
            'data' => [
                'type' => 'budgets',
                'id' => '1',
                'attributes' => ['title' => 'Budget 1'],
            ],
        ]),
    ]);

    $response = $this->timatic
        ->withMockClient($mockClient)
        ->send(new GetBudgets);

    $firstItem = $response->firstItem();
    expect($firstItem)->toBeArray();
    expect($firstItem['id'])->toBe('1');
    expect($firstItem['attributes']['title'])->toBe('Budget 1');
});

it('detects errors in response', function () {
    $mockClient = new MockClient([
        MockResponse::make([
            'errors' => [
                [
                    'status' => '404',
                    'title' => 'Not Found',
                    'detail' => 'Budget not found',
                ],
            ],
        ], 404),
    ]);

    $response = $this->timatic
        ->withMockClient($mockClient)
        ->send(new GetBudgets);

    expect($response->hasErrors())->toBeTrue();
    expect($response->errors())->toBeArray();
    expect($response->errors())->toHaveCount(1);
    expect($response->errors()[0]['status'])->toBe('404');
    expect($response->errors()[0]['title'])->toBe('Not Found');
});

it('returns empty array when no errors exist', function () {
    $mockClient = new MockClient([
        MockResponse::make([
            'data' => [
                ['type' => 'budgets', 'id' => '1'],
            ],
        ]),
    ]);

    $response = $this->timatic
        ->withMockClient($mockClient)
        ->send(new GetBudgets);

    expect($response->hasErrors())->toBeFalse();
    expect($response->errors())->toBeArray();
    expect($response->errors())->toHaveCount(0);
});

it('returns meta information from response', function () {
    $mockClient = new MockClient([
        MockResponse::make([
            'data' => [],
            'meta' => [
                'total' => 100,
                'page' => 1,
                'perPage' => 20,
            ],
        ]),
    ]);

    $response = $this->timatic
        ->withMockClient($mockClient)
        ->send(new GetBudgets);

    expect($response->meta())->toBeArray();
    expect($response->meta()['total'])->toBe(100);
    expect($response->meta()['page'])->toBe(1);
    expect($response->meta()['perPage'])->toBe(20);
});

it('returns empty array when no meta exists', function () {
    $mockClient = new MockClient([
        MockResponse::make([
            'data' => [],
        ]),
    ]);

    $response = $this->timatic
        ->withMockClient($mockClient)
        ->send(new GetBudgets);

    expect($response->meta())->toBeArray();
    expect($response->meta())->toHaveCount(0);
});

it('returns links from response', function () {
    $mockClient = new MockClient([
        MockResponse::make([
            'data' => [],
            'links' => [
                'self' => 'https://api.app.timatic.test/budgets',
                'first' => 'https://api.app.timatic.test/budgets?page[number]=1',
                'next' => 'https://api.app.timatic.test/budgets?page[number]=2',
            ],
        ]),
    ]);

    $response = $this->timatic
        ->withMockClient($mockClient)
        ->send(new GetBudgets);

    expect($response->links())->toBeArray();
    expect($response->links()['self'])->toBe('https://api.app.timatic.test/budgets');
    expect($response->links()['next'])->toBe('https://api.app.timatic.test/budgets?page[number]=2');
});

it('returns empty array when no links exist', function () {
    $mockClient = new MockClient([
        MockResponse::make([
            'data' => [],
        ]),
    ]);

    $response = $this->timatic
        ->withMockClient($mockClient)
        ->send(new GetBudgets);

    expect($response->links())->toBeArray();
    expect($response->links())->toHaveCount(0);
});

it('returns included resources from response', function () {
    $mockClient = new MockClient([
        MockResponse::make([
            'data' => [
                [
                    'type' => 'budgets',
                    'id' => '1',
                    'attributes' => ['title' => 'Budget 1'],
                    'relationships' => [
                        'customer' => [
                            'data' => ['type' => 'customers', 'id' => '10'],
                        ],
                    ],
                ],
            ],
            'included' => [
                [
                    'type' => 'customers',
                    'id' => '10',
                    'attributes' => ['name' => 'Acme Corp'],
                ],
            ],
        ]),
    ]);

    $response = $this->timatic
        ->withMockClient($mockClient)
        ->send(new GetBudgets);

    expect($response->included())->toBeArray();
    expect($response->included())->toHaveCount(1);
    expect($response->included()[0]['type'])->toBe('customers');
    expect($response->included()[0]['id'])->toBe('10');
    expect($response->included()[0]['attributes']['name'])->toBe('Acme Corp');
});

it('returns empty array when no included resources exist', function () {
    $mockClient = new MockClient([
        MockResponse::make([
            'data' => [],
        ]),
    ]);

    $response = $this->timatic
        ->withMockClient($mockClient)
        ->send(new GetBudgets);

    expect($response->included())->toBeArray();
    expect($response->included())->toHaveCount(0);
});
