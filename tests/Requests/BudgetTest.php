<?php

// auto-generated

use Carbon\Carbon;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Requests\Budget\DeleteBudgetRequest;
use Timatic\Requests\Budget\GetBudgetRequest;
use Timatic\Requests\Budget\GetBudgetsCollectionRequest;
use Timatic\Requests\Budget\PatchBudgetRequest;
use Timatic\Requests\Budget\PostBudgetsRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\TimaticConnector;
});

it('calls the getBudgetsCollection method in the Budget resource', function () {
    Saloon::fake([
        GetBudgetsCollectionRequest::class => MockResponse::make([
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
                        'title' => 'Mock value',
                        'description' => 'Mock value',
                        'totalPrice' => 'Mock value',
                        'startedAt' => '2025-11-22T10:40:04.065Z',
                        'endedAt' => '2025-11-22T10:40:04.065Z',
                        'initialMinutes' => 42,
                        'isArchived' => true,
                        'renewalFrequency' => 'Mock value',
                        'supervisorUserId' => 'mock-id-123',
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
                        'title' => 'Mock value',
                        'description' => 'Mock value',
                        'totalPrice' => 'Mock value',
                        'startedAt' => '2025-11-22T10:40:04.065Z',
                        'endedAt' => '2025-11-22T10:40:04.065Z',
                        'initialMinutes' => 42,
                        'isArchived' => true,
                        'renewalFrequency' => 'Mock value',
                        'supervisorUserId' => 'mock-id-123',
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

    $request = (new GetBudgetsCollectionRequest)
        ->filter('customerId', 'customer_id-123')
        ->filter('budgetTypeId', 'budget_type_id-123')
        ->filter('isArchived', true)
        ->includeEntries()
        ->includeBudgetType()
        ->includeCustomer();

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(function (GetBudgetsCollectionRequest $request) {
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
        ->customerId->toBe('mock-id-123')
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
        ->supervisorUserId->toBe('mock-id-123')
        ->entries->not->toBeNull()
        ->budgetType->toBeInstanceOf(\Timatic\Dto\BudgetType::class)
        ->customer->toBeInstanceOf(\Timatic\Dto\Customer::class);
});

it('calls the postBudgets method in the Budget resource', function () {
    $mockClient = Saloon::fake([
        PostBudgetsRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = \Timatic\Dto\Budget::factory()->state([
        'budgetTypeId' => 'budget_type_id-123',
        'customerId' => 'customer_id-123',
        'showToCustomer' => true,
        'changeId' => 'change_id-123',
    ])->make();

    $request = new PostBudgetsRequest($dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(PostBudgetsRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('budgets')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->budgetTypeId->toBe('budget_type_id-123')
            ->customerId->toBe('customer_id-123')
            ->showToCustomer->toBe(true)
            ->changeId->toBe('change_id-123')
            );

        return true;
    });
});

it('calls the getBudget method in the Budget resource', function () {
    Saloon::fake([
        GetBudgetRequest::class => MockResponse::make([
            'data' => [
                'type' => 'budgets',
                'id' => 'mock-id-123',
                'attributes' => [
                    'budgetTypeId' => 'mock-id-123',
                    'customerId' => 'mock-id-123',
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
                    'supervisorUserId' => 'mock-id-123',
                ],
            ],
        ], 200),
    ]);

    $request = new GetBudgetRequest(
        budgetId: 'test string'
    );
    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetBudgetRequest::class);

    expect($response->status())->toBe(200);

    $dto = $response->dto();

    expect($dto)
        ->budgetTypeId->toBe('mock-id-123')
        ->customerId->toBe('mock-id-123')
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
        ->supervisorUserId->toBe('mock-id-123');
});

it('calls the deleteBudget method in the Budget resource', function () {
    Saloon::fake([
        DeleteBudgetRequest::class => MockResponse::make([], 200),
    ]);

    $request = new DeleteBudgetRequest(
        budgetId: 'test string'
    );
    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(DeleteBudgetRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the patchBudget method in the Budget resource', function () {
    $mockClient = Saloon::fake([
        PatchBudgetRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = \Timatic\Dto\Budget::factory()->state([
        'budgetTypeId' => 'budget_type_id-123',
        'customerId' => 'customer_id-123',
        'showToCustomer' => true,
        'changeId' => 'change_id-123',
    ])->make();

    $request = new PatchBudgetRequest(budgetId: 'test string', data: $dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(PatchBudgetRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('budgets')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->budgetTypeId->toBe('budget_type_id-123')
            ->customerId->toBe('customer_id-123')
            ->showToCustomer->toBe(true)
            ->changeId->toBe('change_id-123')
            );

        return true;
    });
});
