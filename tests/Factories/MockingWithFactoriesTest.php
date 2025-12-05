<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Timatic\Dto\Budget;
use Timatic\Requests\Budget\GetBudgetsRequest;
use Timatic\Requests\Budget\PostBudgetsRequest;
use Timatic\TimaticConnector;

test('it can mock a single budget response using factory', function () {
    $budget = Budget::factory()->state([
        'id' => 'mock-123',
        'title' => 'Mocked Budget',
    ])->make();

    $mockClient = new MockClient([
        GetBudgetsRequest::class => MockResponse::make([
            'data' => [$budget->toJsonApi()],
        ], 200),
    ]);

    $connector = new TimaticConnector;
    $connector->withMockClient($mockClient);

    $response = $connector->send(new GetBudgetsRequest);
    $dtos = $response->dto();

    expect($dtos)->toBeInstanceOf(\Illuminate\Support\Collection::class);

    expect($dtos->first())
        ->toBeInstanceOf(Budget::class)
        ->id->toBe('mock-123')
        ->title->toBe('Mocked Budget');
});

test('it can mock a collection response using factories', function () {
    $budgets = Budget::factory()->withId()->count(3)->make();

    $mockClient = new MockClient([
        GetBudgetsRequest::class => MockResponse::make([
            'data' => $budgets->map(fn ($budget) => $budget->toJsonApi())->toArray(),
        ], 200),
    ]);

    $connector = new TimaticConnector;
    $connector->withMockClient($mockClient);

    $response = $connector->send(new GetBudgetsRequest);
    $dtos = $response->dto();

    expect($dtos)->toHaveCount(3);
    $dtos->each(fn ($dto) => expect($dto)->toBeInstanceOf(Budget::class));
});

test('it can mock a POST request to create a budget using factory', function () {
    // Create a budget to send
    $budgetToCreate = Budget::factory()->state([
        'title' => 'New Budget',
        'totalPrice' => '5000.00',
        'customerId' => 'customer-123',
    ])->make();

    // Mock the response with an ID
    $createdBudget = Budget::factory()->state([
        'id' => 'created-456',
        'title' => 'New Budget',
        'totalPrice' => '5000.00',
        'customerId' => 'customer-123',
    ])->make();

    $mockClient = new MockClient([
        PostBudgetsRequest::class => MockResponse::make([
            'data' => $createdBudget->toJsonApi(),
        ], 201),
    ]);

    $connector = new TimaticConnector;
    $connector->withMockClient($mockClient);

    // Send POST request
    $response = $connector->send(new PostBudgetsRequest($budgetToCreate));

    // Assert the request body was sent correctly
    $mockClient->assertSent(function (\Saloon\Http\Request $request) {
        $body = $request->body()->all();

        return $body['data']['type'] === 'budgets'
            && $body['data']['attributes']['title'] === 'New Budget'
            && $body['data']['attributes']['totalPrice'] === '5000.00'
            && $body['data']['attributes']['customerId'] === 'customer-123';
    });

    // Assert response
    expect($response->status())->toBe(201);

    $dto = $response->dto();

    expect($dto)
        ->toBeInstanceOf(Budget::class)
        ->id->toBe('created-456')
        ->title->toBe('New Budget')
        ->totalPrice->toBe('5000.00')
        ->customerId->toBe('customer-123');
});

test('it preserves all factory-generated attributes in json api format', function () {
    $budget = Budget::factory()->state([
        'id' => '123',
        'title' => 'Full Budget',
        'totalPrice' => '5000.00',
        'customerId' => 'customer-456',
        'budgetTypeId' => 'type-789',
        'showToCustomer' => true,
        'isArchived' => false,
    ])->make();

    $jsonApi = $budget->toJsonApi();

    expect($jsonApi)
        ->attributes->toHaveKey('title', 'Full Budget')
        ->toHaveKey('totalPrice', '5000.00')
        ->toHaveKey('customerId', 'customer-456')
        ->toHaveKey('budgetTypeId', 'type-789')
        ->toHaveKey('showToCustomer', true)
        ->toHaveKey('isArchived', false);
});
