<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Dto\Budget;
use Timatic\Dto\BudgetType;
use Timatic\Dto\Customer;
use Timatic\Dto\Entry;
use Timatic\Requests\Budget\GetBudgetsCollectionRequest;
use Timatic\TimaticConnector;

beforeEach(function () {
    $this->timaticConnector = new TimaticConnector;
});

it('can include relationships using fluent API', function () {
    Saloon::fake([
        GetBudgetsCollectionRequest::class => MockResponse::make([
            'data' => [
                [
                    'type' => 'budgets',
                    'id' => 'budget-1',
                    'attributes' => [
                        'title' => 'Test Budget',
                        'budgetTypeId' => 'type-1',
                        'customerId' => 'customer-1',
                    ],
                    'relationships' => [
                        'budgetType' => [
                            'data' => ['type' => 'budgetTypes', 'id' => 'type-1'],
                        ],
                        'customer' => [
                            'data' => ['type' => 'customers', 'id' => 'customer-1'],
                        ],
                        'entries' => [
                            'data' => [
                                ['type' => 'entries', 'id' => 'entry-1'],
                                ['type' => 'entries', 'id' => 'entry-2'],
                            ],
                        ],
                    ],
                ],
            ],
            'included' => [
                [
                    'type' => 'budgetTypes',
                    'id' => 'type-1',
                    'attributes' => ['title' => 'Fixed Price'],
                ],
                [
                    'type' => 'customers',
                    'id' => 'customer-1',
                    'attributes' => ['name' => 'Acme Corp'],
                ],
                [
                    'type' => 'entries',
                    'id' => 'entry-1',
                    'attributes' => ['description' => 'Entry 1'],
                ],
                [
                    'type' => 'entries',
                    'id' => 'entry-2',
                    'attributes' => ['description' => 'Entry 2'],
                ],
            ],
        ], 200),
    ]);

    $request = (new GetBudgetsCollectionRequest)
        ->includeBudgetType()
        ->includeCustomer()
        ->includeEntries();

    $response = $this->timaticConnector->send($request);

    // Verify include parameter was sent
    Saloon::assertSent(function (GetBudgetsCollectionRequest $request) {
        $query = $request->query()->all();
        expect($query)->toHaveKey('include', 'budgetType,customer,entries');

        return true;
    });

    $budgets = $response->dto();
    $budget = $budgets->first();

    // Verify relationships were hydrated
    expect($budget)
        ->toBeInstanceOf(Budget::class)
        ->budgetType->toBeInstanceOf(BudgetType::class)
        ->budgetType->title->toBe('Fixed Price')
        ->customer->toBeInstanceOf(Customer::class)
        ->customer->name->toBe('Acme Corp')
        ->entries->toHaveCount(2)
        ->entries->first()->toBeInstanceOf(Entry::class)
        ->entries->first()->description->toBe('Entry 1');
});

it('can use generic include method', function () {
    Saloon::fake([
        GetBudgetsCollectionRequest::class => MockResponse::make([
            'data' => [],
        ], 200),
    ]);

    $request = (new GetBudgetsCollectionRequest)
        ->include('budgetType', 'customer', 'entries');

    $this->timaticConnector->send($request);

    Saloon::assertSent(function (GetBudgetsCollectionRequest $request) {
        $query = $request->query()->all();
        expect($query)->toHaveKey('include', 'budgetType,customer,entries');

        return true;
    });
});

it('can chain multiple include methods', function () {
    Saloon::fake([
        GetBudgetsCollectionRequest::class => MockResponse::make([
            'data' => [],
        ], 200),
    ]);

    $request = (new GetBudgetsCollectionRequest)
        ->includeBudgetType()
        ->includeEntries()
        ->includeCustomer()
        ->includeCurrentPeriod();

    $this->timaticConnector->send($request);

    Saloon::assertSent(function (GetBudgetsCollectionRequest $request) {
        $query = $request->query()->all();
        expect($query)->toHaveKey('include', 'budgetType,entries,customer,currentPeriod');

        return true;
    });
});

it('does not send include parameter when no includes are added', function () {
    Saloon::fake([
        GetBudgetsCollectionRequest::class => MockResponse::make([
            'data' => [],
        ], 200),
    ]);

    $request = new GetBudgetsCollectionRequest;

    $this->timaticConnector->send($request);

    Saloon::assertSent(function (GetBudgetsCollectionRequest $request) {
        $query = $request->query()->all();
        expect($query)->not->toHaveKey('include');

        return true;
    });
});

it('handles missing included data gracefully', function () {
    Saloon::fake([
        GetBudgetsCollectionRequest::class => MockResponse::make([
            'data' => [
                [
                    'type' => 'budgets',
                    'id' => 'budget-1',
                    'attributes' => [
                        'title' => 'Test Budget',
                    ],
                    'relationships' => [
                        'budgetType' => [
                            'data' => ['type' => 'budgetTypes', 'id' => 'type-1'],
                        ],
                    ],
                ],
            ],
            'included' => [], // No included data
        ], 200),
    ]);

    $request = (new GetBudgetsCollectionRequest)
        ->includeBudgetType();

    $response = $this->timaticConnector->send($request);
    $budgets = $response->dto();
    $budget = $budgets->first();

    // Relationship should be null when not in included array
    expect($budget->budgetType)->toBeNull();
});

it('handles many relationships correctly', function () {
    Saloon::fake([
        GetBudgetsCollectionRequest::class => MockResponse::make([
            'data' => [
                [
                    'type' => 'budgets',
                    'id' => 'budget-1',
                    'attributes' => [
                        'title' => 'Test Budget',
                    ],
                    'relationships' => [
                        'entries' => [
                            'data' => [
                                ['type' => 'entries', 'id' => 'entry-1'],
                                ['type' => 'entries', 'id' => 'entry-2'],
                                ['type' => 'entries', 'id' => 'entry-3'],
                            ],
                        ],
                    ],
                ],
            ],
            'included' => [
                [
                    'type' => 'entries',
                    'id' => 'entry-1',
                    'attributes' => ['description' => 'First Entry'],
                ],
                [
                    'type' => 'entries',
                    'id' => 'entry-2',
                    'attributes' => ['description' => 'Second Entry'],
                ],
                [
                    'type' => 'entries',
                    'id' => 'entry-3',
                    'attributes' => ['description' => 'Third Entry'],
                ],
            ],
        ], 200),
    ]);

    $request = (new GetBudgetsCollectionRequest)
        ->includeEntries();

    $response = $this->timaticConnector->send($request);
    $budget = $response->dto()->first();

    expect($budget->entries)
        ->toHaveCount(3)
        ->each(fn ($entry) => $entry->toBeInstanceOf(Entry::class));

    expect($budget->entries->pluck('description')->toArray())->toBe([
        'First Entry',
        'Second Entry',
        'Third Entry',
    ]);
});
