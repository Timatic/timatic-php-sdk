<?php

// auto-generated

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Requests\EntrySuggestion\EntrySuggestionsCollectionRequest;
use Timatic\Requests\EntrySuggestion\EntrySuggestionsDestroyRequest;
use Timatic\Requests\EntrySuggestion\EntrySuggestionsShowRequest;
use Timatic\TimaticConnector;

beforeEach(function () {
    $this->timaticConnector = new TimaticConnector;
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
                        'ticketNumber' => 'String value',
                        'customerId' => 'mock-id-123',
                        'userId' => 'mock-id-123',
                        'date' => 'String value',
                        'ticketTitle' => 'String value',
                        'ticketType' => 'String value',
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
                        'ticketNumber' => 'String value',
                        'customerId' => 'mock-id-123',
                        'userId' => 'mock-id-123',
                        'date' => 'String value',
                        'ticketTitle' => 'String value',
                        'ticketType' => 'String value',
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

    $dtoCollection = $this->timaticConnector->paginate($request)->dtoCollection();

    Saloon::assertSent(function (EntrySuggestionsCollectionRequest $request) {
        $query = $request->query()->all();
        expect($query)->toHaveKey('filter[date]', 'test value');
        expect($query)->toHaveKey('include', 'activities');

        return true;
    });

    expect($dtoCollection)->toHaveCount(2);

    expect($dtoCollection->first())
        ->ticketId->toBe('mock-id-123')
        ->ticketNumber->toBe('String value')
        ->customerId->toBe('mock-id-123')
        ->userId->toBe('mock-id-123')
        ->date->toBe('String value')
        ->ticketTitle->toBe('String value')
        ->ticketType->toBe('String value')
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
                    'ticketNumber' => 'String value',
                    'customerId' => 'mock-id-123',
                    'userId' => 'mock-id-123',
                    'date' => 'String value',
                    'ticketTitle' => 'String value',
                    'ticketType' => 'String value',
                    'budgetId' => 42,
                ],
            ],
        ], 200),
    ]);

    $request = new EntrySuggestionsShowRequest(
        entrySuggestionId: null
    );
    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(EntrySuggestionsShowRequest::class);

    expect($response->status())->toBe(200);

    $dto = $response->dto();

    expect($dto)
        ->ticketId->toBe('mock-id-123')
        ->ticketNumber->toBe('String value')
        ->customerId->toBe('mock-id-123')
        ->userId->toBe('mock-id-123')
        ->date->toBe('String value')
        ->ticketTitle->toBe('String value')
        ->ticketType->toBe('String value')
        ->budgetId->toBe(42);
});

it('calls the entrySuggestionsDestroy method in the EntrySuggestion resource', function () {
    Saloon::fake([
        EntrySuggestionsDestroyRequest::class => MockResponse::make([], 200),
    ]);

    $request = new EntrySuggestionsDestroyRequest(
        entrySuggestionId: null
    );
    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(EntrySuggestionsDestroyRequest::class);

    expect($response->status())->toBe(200);
});
