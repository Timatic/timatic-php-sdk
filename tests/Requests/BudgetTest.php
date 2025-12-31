<?php

// auto-generated

use Carbon\Carbon;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Requests\Budget\BudgetsCollectionRequest;
use Timatic\Requests\Budget\BudgetsDestroyRequest;
use Timatic\Requests\Budget\BudgetsShowRequest;
use Timatic\Requests\Budget\BudgetsStoreRequest;
use Timatic\Requests\Budget\BudgetsUpdateRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\TimaticConnector;
});

it('calls the budgetsCollection method in the Budget resource', function () {
    Saloon::fake([
        BudgetsCollectionRequest::class => MockResponse::make([
            'data' => [
                0 => [
                    'type' => 'budgets',
                    'id' => 'mock-id-1',
                    'attributes' => [
                        'budgetTypeId' => 'mock-id-123',
                        'customerId' => 42,
                        'showToCustomer' => true,
                        'changeId' => 'mock-id-123',
                        'contractId' => 'mock-id-123',
                        'title' => 'Mock value',
                        'description' => 'Mock value',
                        'totalPrice' => 'Mock value',
                        'startedAt' => '2025-11-22T10:40:04.065Z',
                        'endedAt' => '2025-11-22T10:40:04.065Z',
                        'initialMinutes' => 42,
                        'isArchived' => true,
                        'renewalFrequency' => 'Mock value',
                        'supervisorUserId' => 42,
                    ],
                    'relationships' => [
                        'entries' => [
                            'data' => [
                                0 => [
                                    'type' => 'entries',
                                    'id' => 'related-entries-1',
                                ],
                            ],
                        ],
                        'budgetType' => [
                            'data' => [
                                'type' => 'budgettypes',
                                'id' => 'related-budgetType-1',
                            ],
                        ],
                        'customer' => [
                            'data' => [
                                'type' => 'customers',
                                'id' => 'related-customer-1',
                            ],
                        ],
                    ],
                ],
                1 => [
                    'type' => 'budgets',
                    'id' => 'mock-id-2',
                    'attributes' => [
                        'budgetTypeId' => 'mock-id-123',
                        'customerId' => 42,
                        'showToCustomer' => true,
                        'changeId' => 'mock-id-123',
                        'contractId' => 'mock-id-123',
                        'title' => 'Mock value',
                        'description' => 'Mock value',
                        'totalPrice' => 'Mock value',
                        'startedAt' => '2025-11-22T10:40:04.065Z',
                        'endedAt' => '2025-11-22T10:40:04.065Z',
                        'initialMinutes' => 42,
                        'isArchived' => true,
                        'renewalFrequency' => 'Mock value',
                        'supervisorUserId' => 42,
                    ],
                    'relationships' => [
                        'entries' => [
                            'data' => [
                                0 => [
                                    'type' => 'entries',
                                    'id' => 'related-entries-1',
                                ],
                            ],
                        ],
                        'budgetType' => [
                            'data' => [
                                'type' => 'budgettypes',
                                'id' => 'related-budgetType-1',
                            ],
                        ],
                        'customer' => [
                            'data' => [
                                'type' => 'customers',
                                'id' => 'related-customer-1',
                            ],
                        ],
                    ],
                ],
            ],
            'included' => [
                0 => [
                    'type' => 'entries',
                    'id' => 'related-entries-1',
                    'attributes' => [],
                ],
                1 => [
                    'type' => 'budgettypes',
                    'id' => 'related-budgetType-1',
                    'attributes' => [],
                ],
                2 => [
                    'type' => 'customers',
                    'id' => 'related-customer-1',
                    'attributes' => [],
                ],
            ],
        ], 200),
    ]);

    $request = (new BudgetsCollectionRequest(pagesize: 123, pagenumber: 123))
        ->filter('customerId', 'customer_id-123')
        ->filter('budgetTypeId', 'budget_type_id-123')
        ->filter('isArchived', true)
        ->includeEntries()
        ->includeBudgetType()
        ->includeCustomer();

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(function (BudgetsCollectionRequest $request) {
        $query = $request->query()->all();
        expect($query)->toHaveKey('filter[customerId]', 'customer_id-123');
        expect($query)->toHaveKey('filter[budgetTypeId]', 'budget_type_id-123');
        expect($query)->toHaveKey('filter[isArchived]', true);
        expect($query)->toHaveKey('include', 'entries,budgetType,customer');

        return true;
    });

    expect($response->status())->toBe(200);

    $dtoCollection = $response->dto();

    expect($dtoCollection->first())
        ->budgetTypeId->toBe('mock-id-123')
        ->customerId->toBe(42)
        ->showToCustomer->toBe(true)
        ->changeId->toBe('mock-id-123')
        ->contractId->toBe('mock-id-123')
        ->title->toBe('Mock value')
        ->description->toBe('Mock value')
        ->totalPrice->toBe('Mock value')
        ->startedAt->toEqual(new Carbon('2025-11-22T10:40:04.065Z'))
        ->endedAt->toEqual(new Carbon('2025-11-22T10:40:04.065Z'))
        ->initialMinutes->toBe(42)
        ->isArchived->toBe(true)
        ->renewalFrequency->toBe('Mock value')
        ->supervisorUserId->toBe(42)
        ->entries->not->toBeNull()
        ->budgetType->toBeInstanceOf(\Timatic\Dto\BudgetType::class)
        ->customer->toBeInstanceOf(\Timatic\Dto\Customer::class);
});

it('calls the budgetsStore method in the Budget resource', function () {
    $mockClient = Saloon::fake([
        BudgetsStoreRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = \Timatic\Dto\Budget::factory()->state([
        'budgetTypeId' => 'budget_type_id-123',
        'customerId' => 42,
        'showToCustomer' => true,
        'changeId' => 'change_id-123',
    ])->make();

    $request = new BudgetsStoreRequest($dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(BudgetsStoreRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('budgets')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->budgetTypeId->toBe('budget_type_id-123')
            ->customerId->toBe(42)
            ->showToCustomer->toBe(true)
            ->changeId->toBe('change_id-123')
            );

        return true;
    });
});

it('calls the budgetsShow method in the Budget resource', function () {
    Saloon::fake([
        BudgetsShowRequest::class => MockResponse::make([
            'data' => [
                'type' => 'budgets',
                'id' => 'mock-id-123',
                'attributes' => [
                    'budgetTypeId' => 'mock-id-123',
                    'customerId' => 42,
                    'showToCustomer' => true,
                    'changeId' => 'mock-id-123',
                    'contractId' => 'mock-id-123',
                    'title' => 'Mock value',
                    'description' => 'Mock value',
                    'totalPrice' => 'Mock value',
                    'startedAt' => '2025-11-22T10:40:04.065Z',
                    'endedAt' => '2025-11-22T10:40:04.065Z',
                    'initialMinutes' => 42,
                    'isArchived' => true,
                    'renewalFrequency' => 'Mock value',
                    'supervisorUserId' => 42,
                ],
            ],
        ], 200),
    ]);

    $request = new BudgetsShowRequest(
        budgetId: 123
    );
    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(BudgetsShowRequest::class);

    expect($response->status())->toBe(200);

    $dto = $response->dto();

    expect($dto)
        ->budgetTypeId->toBe('mock-id-123')
        ->customerId->toBe(42)
        ->showToCustomer->toBe(true)
        ->changeId->toBe('mock-id-123')
        ->contractId->toBe('mock-id-123')
        ->title->toBe('Mock value')
        ->description->toBe('Mock value')
        ->totalPrice->toBe('Mock value')
        ->startedAt->toEqual(new Carbon('2025-11-22T10:40:04.065Z'))
        ->endedAt->toEqual(new Carbon('2025-11-22T10:40:04.065Z'))
        ->initialMinutes->toBe(42)
        ->isArchived->toBe(true)
        ->renewalFrequency->toBe('Mock value')
        ->supervisorUserId->toBe(42);
});

it('calls the budgetsDestroy method in the Budget resource', function () {
    Saloon::fake([
        BudgetsDestroyRequest::class => MockResponse::make([], 200),
    ]);

    $request = new BudgetsDestroyRequest(
        budgetId: 123
    );
    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(BudgetsDestroyRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the budgetsUpdate method in the Budget resource', function () {
    $mockClient = Saloon::fake([
        BudgetsUpdateRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = \Timatic\Dto\Budget::factory()->state([
        'budgetTypeId' => 'budget_type_id-123',
        'customerId' => 42,
        'showToCustomer' => true,
        'changeId' => 'change_id-123',
    ])->make();

    $request = new BudgetsUpdateRequest(budgetId: 42, data: $dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(BudgetsUpdateRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('budgets')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->budgetTypeId->toBe('budget_type_id-123')
            ->customerId->toBe(42)
            ->showToCustomer->toBe(true)
            ->changeId->toBe('change_id-123')
            );

        return true;
    });
});
