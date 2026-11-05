<?php

// auto-generated

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Dto\Budget;
use Timatic\Dto\Customer;
use Timatic\Dto\TrackedDomainCreateRequest;
use Timatic\Requests\TrackedDomain\TrackedDomainsCollectionRequest;
use Timatic\Requests\TrackedDomain\TrackedDomainsDestroyRequest;
use Timatic\Requests\TrackedDomain\TrackedDomainsStoreRequest;
use Timatic\TimaticConnector;

beforeEach(function () {
    $this->timaticConnector = new TimaticConnector;
});

it('calls the trackedDomainsCollection method in the TrackedDomain resource', function () {
    Saloon::fake([
        TrackedDomainsCollectionRequest::class => MockResponse::make([
            'data' => [
                0 => [
                    'type' => 'trackedDomains',
                    'id' => 'mock-id-1',
                    'attributes' => [
                        'domain' => 'String value',
                        'path' => 'String value',
                        'customerId' => 42,
                        'budgetId' => 42,
                        'isInternal' => true,
                        'userId' => 42,
                        'parentId' => 42,
                    ],
                    'relationships' => [
                        'customer' => [
                            'data' => [
                                'type' => 'customers',
                                'id' => 'related-customer-1',
                            ],
                        ],
                        'budget' => [
                            'data' => [
                                'type' => 'budgets',
                                'id' => 'related-budget-1',
                            ],
                        ],
                    ],
                ],
                1 => [
                    'type' => 'trackedDomains',
                    'id' => 'mock-id-2',
                    'attributes' => [
                        'domain' => 'String value',
                        'path' => 'String value',
                        'customerId' => 42,
                        'budgetId' => 42,
                        'isInternal' => true,
                        'userId' => 42,
                        'parentId' => 42,
                    ],
                    'relationships' => [
                        'customer' => [
                            'data' => [
                                'type' => 'customers',
                                'id' => 'related-customer-1',
                            ],
                        ],
                        'budget' => [
                            'data' => [
                                'type' => 'budgets',
                                'id' => 'related-budget-1',
                            ],
                        ],
                    ],
                ],
            ],
            'included' => [
                0 => [
                    'type' => 'customers',
                    'id' => 'related-customer-1',
                    'attributes' => [],
                ],
                1 => [
                    'type' => 'budgets',
                    'id' => 'related-budget-1',
                    'attributes' => [],
                ],
            ],
        ], 200),
    ]);

    $request = (new TrackedDomainsCollectionRequest(pagesize: 123, pagenumber: 123))
        ->filter('domain', 'test value')
        ->filter('customerId', 'customer_id-123')
        ->filter('userId', 'user_id-123')
        ->includeCustomer()
        ->includeBudget();

    $dtoCollection = $this->timaticConnector->paginate($request)->dtoCollection();

    Saloon::assertSent(function (TrackedDomainsCollectionRequest $request) {
        $query = $request->query()->all();
        expect($query)->toHaveKey('filter[domain]', 'test value');
        expect($query)->toHaveKey('filter[customerId]', 'customer_id-123');
        expect($query)->toHaveKey('filter[userId]', 'user_id-123');
        expect($query)->toHaveKey('include', 'customer,budget');

        return true;
    });

    expect($dtoCollection)->toHaveCount(2);

    expect($dtoCollection->first())
        ->domain->toBe('String value')
        ->path->toBe('String value')
        ->customerId->toBe(42)
        ->budgetId->toBe(42)
        ->isInternal->toBe(true)
        ->userId->toBe(42)
        ->parentId->toBe(42)
        ->customer->toBeInstanceOf(Customer::class)
        ->budget->toBeInstanceOf(Budget::class);
});

it('calls the trackedDomainsStore method in the TrackedDomain resource', function () {
    $mockClient = Saloon::fake([
        TrackedDomainsStoreRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = TrackedDomainCreateRequest::testFactory()->state([
        'domain' => 'test value',
        'customerId' => 42,
        'isInternal' => true,
        'userId' => 42,
    ])->make();

    $request = new TrackedDomainsStoreRequest($dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(TrackedDomainsStoreRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('tracked-domains')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->domain->toBe('test value')
            ->customerId->toBe(42)
            ->isInternal->toBe(true)
            ->userId->toBe(42)
            );

        return true;
    });
});

it('calls the trackedDomainsDestroy method in the TrackedDomain resource', function () {
    Saloon::fake([
        TrackedDomainsDestroyRequest::class => MockResponse::make([], 200),
    ]);

    $request = new TrackedDomainsDestroyRequest(
        trackedDomainId: null
    );
    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(TrackedDomainsDestroyRequest::class);

    expect($response->status())->toBe(200);
});
