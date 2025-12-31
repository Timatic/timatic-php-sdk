<?php

// auto-generated

use Carbon\Carbon;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Requests\Entry\EntriesCollectionRequest;
use Timatic\Requests\Entry\EntriesDestroyRequest;
use Timatic\Requests\Entry\EntriesShowRequest;
use Timatic\Requests\Entry\EntriesStoreRequest;
use Timatic\Requests\Entry\EntriesUpdateRequest;
use Timatic\Requests\Entry\EntryMarkAsInvoicedRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\TimaticConnector;
});

it('calls the entriesCollection method in the Entry resource', function () {
    Saloon::fake([
        EntriesCollectionRequest::class => MockResponse::make([
            'data' => [
                0 => [
                    'type' => 'entries',
                    'id' => 'mock-id-1',
                    'attributes' => [
                        'ticketId' => 'mock-id-123',
                        'ticketNumber' => 'Mock value',
                        'ticketTitle' => 'Mock value',
                        'ticketType' => 'Mock value',
                        'customerId' => 42,
                        'customerName' => 'Mock value',
                        'hourlyRate' => 3.14,
                        'hadEmergencyShift' => true,
                        'budgetId' => 42,
                        'isPaidPerHour' => 'Mock value',
                        'minutesSpent' => 42,
                        'userId' => 42,
                        'userEmail' => 'test@example.com',
                        'userFullName' => 'Mock value',
                        'createdByUserId' => 42,
                        'createdByUserEmail' => 'test@example.com',
                        'createdByUserFullName' => 'Mock value',
                        'entryType' => 'Mock value',
                        'description' => 'Mock value',
                        'isInternal' => true,
                        'startedAt' => '2025-11-22T10:40:04.065Z',
                        'endedAt' => '2025-11-22T10:40:04.065Z',
                        'invoicedAt' => '2025-11-22T10:40:04.065Z',
                        'isInvoiced' => 'Mock value',
                        'isBasedOnSuggestion' => true,
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
                    'type' => 'entries',
                    'id' => 'mock-id-2',
                    'attributes' => [
                        'ticketId' => 'mock-id-123',
                        'ticketNumber' => 'Mock value',
                        'ticketTitle' => 'Mock value',
                        'ticketType' => 'Mock value',
                        'customerId' => 42,
                        'customerName' => 'Mock value',
                        'hourlyRate' => 3.14,
                        'hadEmergencyShift' => true,
                        'budgetId' => 42,
                        'isPaidPerHour' => 'Mock value',
                        'minutesSpent' => 42,
                        'userId' => 42,
                        'userEmail' => 'test@example.com',
                        'userFullName' => 'Mock value',
                        'createdByUserId' => 42,
                        'createdByUserEmail' => 'test@example.com',
                        'createdByUserFullName' => 'Mock value',
                        'entryType' => 'Mock value',
                        'description' => 'Mock value',
                        'isInternal' => true,
                        'startedAt' => '2025-11-22T10:40:04.065Z',
                        'endedAt' => '2025-11-22T10:40:04.065Z',
                        'invoicedAt' => '2025-11-22T10:40:04.065Z',
                        'isInvoiced' => 'Mock value',
                        'isBasedOnSuggestion' => true,
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

    $request = (new EntriesCollectionRequest(sort: 'test string', pagesize: 123, pagenumber: 123))
        ->filter('userId', 'user_id-123')
        ->filter('budgetId', 'budget_id-123')
        ->filter('startedAt', '2025-01-15T10:30:00Z')
        ->includeCustomer()
        ->includeBudget();

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(function (EntriesCollectionRequest $request) {
        $query = $request->query()->all();
        expect($query)->toHaveKey('filter[userId]', 'user_id-123');
        expect($query)->toHaveKey('filter[budgetId]', 'budget_id-123');
        expect($query)->toHaveKey('filter[startedAt]', '2025-01-15T10:30:00Z');
        expect($query)->toHaveKey('include', 'customer,budget');

        return true;
    });

    expect($response->status())->toBe(200);

    $dtoCollection = $response->dto();

    expect($dtoCollection->first())
        ->ticketId->toBe('mock-id-123')
        ->ticketNumber->toBe('Mock value')
        ->ticketTitle->toBe('Mock value')
        ->ticketType->toBe('Mock value')
        ->customerId->toBe(42)
        ->customerName->toBe('Mock value')
        ->hourlyRate->toBe(3.14)
        ->hadEmergencyShift->toBe(true)
        ->budgetId->toBe(42)
        ->isPaidPerHour->toBe('Mock value')
        ->minutesSpent->toBe(42)
        ->userId->toBe(42)
        ->userEmail->toBe('test@example.com')
        ->userFullName->toBe('Mock value')
        ->createdByUserId->toBe(42)
        ->createdByUserEmail->toBe('test@example.com')
        ->createdByUserFullName->toBe('Mock value')
        ->entryType->toBe('Mock value')
        ->description->toBe('Mock value')
        ->isInternal->toBe(true)
        ->startedAt->toEqual(new Carbon('2025-11-22T10:40:04.065Z'))
        ->endedAt->toEqual(new Carbon('2025-11-22T10:40:04.065Z'))
        ->invoicedAt->toEqual(new Carbon('2025-11-22T10:40:04.065Z'))
        ->isInvoiced->toBe('Mock value')
        ->isBasedOnSuggestion->toBe(true)
        ->customer->toBeInstanceOf(\Timatic\Dto\Customer::class)
        ->budget->toBeInstanceOf(\Timatic\Dto\Budget::class);
});

it('calls the entriesStore method in the Entry resource', function () {
    $mockClient = Saloon::fake([
        EntriesStoreRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = \Timatic\Dto\Entry::factory()->state([
        'ticketId' => 'ticket_id-123',
        'ticketNumber' => 'test value',
        'ticketTitle' => 'test value',
        'ticketType' => 'test value',
    ])->make();

    $request = new EntriesStoreRequest($dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(EntriesStoreRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('entries')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->ticketId->toBe('ticket_id-123')
            ->ticketNumber->toBe('test value')
            ->ticketTitle->toBe('test value')
            ->ticketType->toBe('test value')
            );

        return true;
    });
});

it('calls the entriesShow method in the Entry resource', function () {
    Saloon::fake([
        EntriesShowRequest::class => MockResponse::make([
            'data' => [
                'type' => 'entries',
                'id' => 'mock-id-123',
                'attributes' => [
                    'ticketId' => 'mock-id-123',
                    'ticketNumber' => 'Mock value',
                    'ticketTitle' => 'Mock value',
                    'ticketType' => 'Mock value',
                    'customerId' => 42,
                    'customerName' => 'Mock value',
                    'hourlyRate' => 3.14,
                    'hadEmergencyShift' => true,
                    'budgetId' => 42,
                    'isPaidPerHour' => 'Mock value',
                    'minutesSpent' => 42,
                    'userId' => 42,
                    'userEmail' => 'test@example.com',
                    'userFullName' => 'Mock value',
                    'createdByUserId' => 42,
                    'createdByUserEmail' => 'test@example.com',
                    'createdByUserFullName' => 'Mock value',
                    'entryType' => 'Mock value',
                    'description' => 'Mock value',
                    'isInternal' => true,
                    'startedAt' => '2025-11-22T10:40:04.065Z',
                    'endedAt' => '2025-11-22T10:40:04.065Z',
                    'invoicedAt' => '2025-11-22T10:40:04.065Z',
                    'isInvoiced' => 'Mock value',
                    'isBasedOnSuggestion' => true,
                ],
            ],
        ], 200),
    ]);

    $request = new EntriesShowRequest(
        entryId: 123
    );
    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(EntriesShowRequest::class);

    expect($response->status())->toBe(200);

    $dto = $response->dto();

    expect($dto)
        ->ticketId->toBe('mock-id-123')
        ->ticketNumber->toBe('Mock value')
        ->ticketTitle->toBe('Mock value')
        ->ticketType->toBe('Mock value')
        ->customerId->toBe(42)
        ->customerName->toBe('Mock value')
        ->hourlyRate->toBe(3.14)
        ->hadEmergencyShift->toBe(true)
        ->budgetId->toBe(42)
        ->isPaidPerHour->toBe('Mock value')
        ->minutesSpent->toBe(42)
        ->userId->toBe(42)
        ->userEmail->toBe('test@example.com')
        ->userFullName->toBe('Mock value')
        ->createdByUserId->toBe(42)
        ->createdByUserEmail->toBe('test@example.com')
        ->createdByUserFullName->toBe('Mock value')
        ->entryType->toBe('Mock value')
        ->description->toBe('Mock value')
        ->isInternal->toBe(true)
        ->startedAt->toEqual(new Carbon('2025-11-22T10:40:04.065Z'))
        ->endedAt->toEqual(new Carbon('2025-11-22T10:40:04.065Z'))
        ->invoicedAt->toEqual(new Carbon('2025-11-22T10:40:04.065Z'))
        ->isInvoiced->toBe('Mock value')
        ->isBasedOnSuggestion->toBe(true);
});

it('calls the entriesDestroy method in the Entry resource', function () {
    Saloon::fake([
        EntriesDestroyRequest::class => MockResponse::make([], 200),
    ]);

    $request = new EntriesDestroyRequest(
        entryId: 123
    );
    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(EntriesDestroyRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the entriesUpdate method in the Entry resource', function () {
    $mockClient = Saloon::fake([
        EntriesUpdateRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = \Timatic\Dto\Entry::factory()->state([
        'ticketId' => 'ticket_id-123',
        'ticketNumber' => 'test value',
        'ticketTitle' => 'test value',
        'ticketType' => 'test value',
    ])->make();

    $request = new EntriesUpdateRequest(entryId: 42, data: $dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(EntriesUpdateRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('entries')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->ticketId->toBe('ticket_id-123')
            ->ticketNumber->toBe('test value')
            ->ticketTitle->toBe('test value')
            ->ticketType->toBe('test value')
            );

        return true;
    });
});

it('calls the entryMarkAsInvoiced method in the Entry resource', function () {
    $mockClient = Saloon::fake([
        EntryMarkAsInvoicedRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = \Timatic\Dto\Entry::factory()->state([
        'ticketId' => 'ticket_id-123',
        'ticketNumber' => 'test value',
        'ticketTitle' => 'test value',
        'ticketType' => 'test value',
    ])->make();

    $request = new EntryMarkAsInvoicedRequest(entryId: 42, data: $dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(EntryMarkAsInvoicedRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('entries')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->ticketId->toBe('ticket_id-123')
            ->ticketNumber->toBe('test value')
            ->ticketTitle->toBe('test value')
            ->ticketType->toBe('test value')
            );

        return true;
    });
});
