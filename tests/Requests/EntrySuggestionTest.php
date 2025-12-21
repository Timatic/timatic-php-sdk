<?php

// auto-generated

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Requests\EntrySuggestion\EntrySuggestionsCollectionRequest;
use Timatic\Requests\EntrySuggestion\EntrySuggestionsDestroyRequest;
use Timatic\Requests\EntrySuggestion\EntrySuggestionsShowRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\TimaticConnector;
});

it('calls the entrySuggestionsCollection method in the EntrySuggestion resource', function () {
    Saloon::fake([
        EntrySuggestionsCollectionRequest::class => MockResponse::make([
            'data' => [
                0 => [
                    'type' => 'entrySuggestions',
                    'id' => 'mock-id-1',
                    'attributes' => [
                        'ticketId' => 'mock-id-123',
                        'ticketNumber' => 'Mock value',
                        'customerId' => 'mock-id-123',
                        'userId' => 42,
                        'date' => 'Mock value',
                        'ticketTitle' => 'Mock value',
                        'ticketType' => 'Mock value',
                        'budgetId' => 42,
                    ],
                    'relationships' => [
                        'activities' => [
                            'data' => [
                                0 => [
                                    'type' => 'activities',
                                    'id' => 'related-activities-1',
                                ],
                            ],
                        ],
                    ],
                ],
                1 => [
                    'type' => 'entrySuggestions',
                    'id' => 'mock-id-2',
                    'attributes' => [
                        'ticketId' => 'mock-id-123',
                        'ticketNumber' => 'Mock value',
                        'customerId' => 'mock-id-123',
                        'userId' => 42,
                        'date' => 'Mock value',
                        'ticketTitle' => 'Mock value',
                        'ticketType' => 'Mock value',
                        'budgetId' => 42,
                    ],
                    'relationships' => [
                        'activities' => [
                            'data' => [
                                0 => [
                                    'type' => 'activities',
                                    'id' => 'related-activities-1',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'included' => [
                0 => [
                    'type' => 'activities',
                    'id' => 'related-activities-1',
                    'attributes' => [],
                ],
            ],
        ], 200),
    ]);

    $request = (new EntrySuggestionsCollectionRequest(pagesize: 123, pagenumber: 123))
        ->filter('date', 'test value')
        ->includeActivities();

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(function (EntrySuggestionsCollectionRequest $request) {
        $query = $request->query()->all();
        expect($query)->toHaveKey('filter[date]', 'test value');
        expect($query)->toHaveKey('include', 'activities');

        return true;
    });

    expect($response->status())->toBe(200);

    $dtoCollection = $response->dto();

    expect($dtoCollection->first())
        ->ticketId->toBe('mock-id-123')
        ->ticketNumber->toBe('Mock value')
        ->customerId->toBe('mock-id-123')
        ->userId->toBe(42)
        ->date->toBe('Mock value')
        ->ticketTitle->toBe('Mock value')
        ->ticketType->toBe('Mock value')
        ->budgetId->toBe(42)
        ->activities->not->toBeNull();
});

it('calls the entrySuggestionsShow method in the EntrySuggestion resource', function () {
    Saloon::fake([
        EntrySuggestionsShowRequest::class => MockResponse::make([
            'data' => [
                'type' => 'entrySuggestions',
                'id' => 'mock-id-123',
                'attributes' => [
                    'ticketId' => 'mock-id-123',
                    'ticketNumber' => 'Mock value',
                    'customerId' => 'mock-id-123',
                    'userId' => 42,
                    'date' => 'Mock value',
                    'ticketTitle' => 'Mock value',
                    'ticketType' => 'Mock value',
                    'budgetId' => 42,
                ],
            ],
        ], 200),
    ]);

    $request = new EntrySuggestionsShowRequest(
        entrySuggestionId: 123
    );
    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(EntrySuggestionsShowRequest::class);

    expect($response->status())->toBe(200);

    $dto = $response->dto();

    expect($dto)
        ->ticketId->toBe('mock-id-123')
        ->ticketNumber->toBe('Mock value')
        ->customerId->toBe('mock-id-123')
        ->userId->toBe(42)
        ->date->toBe('Mock value')
        ->ticketTitle->toBe('Mock value')
        ->ticketType->toBe('Mock value')
        ->budgetId->toBe(42);
});

it('calls the entrySuggestionsDestroy method in the EntrySuggestion resource', function () {
    Saloon::fake([
        EntrySuggestionsDestroyRequest::class => MockResponse::make([], 200),
    ]);

    $request = new EntrySuggestionsDestroyRequest(
        entrySuggestionId: 123
    );
    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(EntrySuggestionsDestroyRequest::class);

    expect($response->status())->toBe(200);
});
