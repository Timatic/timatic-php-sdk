<?php

// auto-generated

use Carbon\Carbon;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Dto\Budget;
use Timatic\Dto\BudgetType;
use Timatic\Dto\Customer;
use Timatic\Requests\Budget\BudgetsCollectionRequest;
use Timatic\Requests\Budget\BudgetsDestroyRequest;
use Timatic\Requests\Budget\BudgetsShowRequest;
use Timatic\Requests\Budget\BudgetsStoreRequest;
use Timatic\Requests\Budget\BudgetsUpdateRequest;
use Timatic\TimaticConnector;

beforeEach(function () {
    $this->timaticConnector = new TimaticConnector;
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
                        'customerId' => 'mock-id-123',
                        'showToCustomer' => true,
                        'changeId' => 'mock-id-123',
                        'contractId' => 'mock-id-123',
                        'title' => 'String value',
                        'description' => 'String value',
                        'totalPrice' => 'String value',
                        'startedAt' => '2025-11-22T10:40:04+00:00',
                        'endedAt' => '2025-11-22T10:40:04+00:00',
                        'initialMinutes' => 42,
                        'isArchived' => true,
                        'renewalFrequency' => 'String value',
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
                        'customerId' => 'mock-id-123',
                        'showToCustomer' => true,
                        'changeId' => 'mock-id-123',
                        'contractId' => 'mock-id-123',
                        'title' => 'String value',
                        'description' => 'String value',
                        'totalPrice' => 'String value',
                        'startedAt' => '2025-11-22T10:40:04+00:00',
                        'endedAt' => '2025-11-22T10:40:04+00:00',
                        'initialMinutes' => 42,
                        'isArchived' => true,
                        'renewalFrequency' => 'String value',
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

    $dtoCollection = $this->timaticConnector->paginate($request)->dtoCollection();

    Saloon::assertSent(function (BudgetsCollectionRequest $request) {
        $query = $request->query()->all();
        expect($query)->toHaveKey('filter[customerId]', 'customer_id-123');
        expect($query)->toHaveKey('filter[budgetTypeId]', 'budget_type_id-123');
        expect($query)->toHaveKey('filter[isArchived]', true);
        expect($query)->toHaveKey('include', 'entries,budgetType,customer');

        return true;
    });

    expect($dtoCollection)->toHaveCount(2);

    expect($dtoCollection->first())
        ->budgetTypeId->toBe('mock-id-123')
        ->customerId->toBe('mock-id-123')
        ->showToCustomer->toBe(true)
        ->changeId->toBe('mock-id-123')
        ->contractId->toBe('mock-id-123')
        ->title->toBe('String value')
        ->description->toBe('String value')
        ->totalPrice->toBe('String value')
        ->startedAt->toEqual(new Carbon('2025-11-22T10:40:04+00:00'))
        ->endedAt->toEqual(new Carbon('2025-11-22T10:40:04+00:00'))
        ->initialMinutes->toBe(42)
        ->isArchived->toBe(true)
        ->renewalFrequency->toBe('String value')
        ->entries->not->toBeNull()
        ->budgetType->toBeInstanceOf(BudgetType::class)
        ->customer->toBeInstanceOf(Customer::class);
});

it('calls the budgetsStore method in the Budget resource', function () {
    $mockClient = Saloon::fake([
        BudgetsStoreRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = Budget::testFactory()->state([
        'budgetTypeId' => 'budget_type_id-123',
        'customerId' => 'customer_id-123',
        'showToCustomer' => true,
        'title' => 'test title',
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
            ->customerId->toBe('customer_id-123')
            ->showToCustomer->toBe(true)
            ->title->toBe('test title')
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
                    'customerId' => 'mock-id-123',
                    'showToCustomer' => true,
                    'changeId' => 'mock-id-123',
                    'contractId' => 'mock-id-123',
                    'title' => 'String value',
                    'description' => 'String value',
                    'totalPrice' => 'String value',
                    'startedAt' => '2025-11-22T10:40:04+00:00',
                    'endedAt' => '2025-11-22T10:40:04+00:00',
                    'initialMinutes' => 42,
                    'isArchived' => true,
                    'renewalFrequency' => 'String value',
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
        ->customerId->toBe('mock-id-123')
        ->showToCustomer->toBe(true)
        ->changeId->toBe('mock-id-123')
        ->contractId->toBe('mock-id-123')
        ->title->toBe('String value')
        ->description->toBe('String value')
        ->totalPrice->toBe('String value')
        ->startedAt->toEqual(new Carbon('2025-11-22T10:40:04+00:00'))
        ->endedAt->toEqual(new Carbon('2025-11-22T10:40:04+00:00'))
        ->initialMinutes->toBe(42)
        ->isArchived->toBe(true)
        ->renewalFrequency->toBe('String value');
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
    $dto = Budget::testFactory()->state([
        'budgetTypeId' => 'budget_type_id-123',
        'customerId' => 'customer_id-123',
        'showToCustomer' => true,
        'title' => 'test title',
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
            ->customerId->toBe('customer_id-123')
            ->showToCustomer->toBe(true)
            ->title->toBe('test title')
            );

        return true;
    });
});
