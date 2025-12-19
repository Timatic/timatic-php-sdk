<?php

// auto-generated

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Requests\EntrySuggestion\DeleteEntrySuggestionRequest;
use Timatic\Requests\EntrySuggestion\GetEntrySuggestionRequest;
use Timatic\Requests\EntrySuggestion\GetEntrySuggestionsCollectionRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\TimaticConnector;
});

it('calls the getEntrySuggestionsCollection method in the EntrySuggestion resource', function () {
    Saloon::fake([
        GetEntrySuggestionsCollectionRequest::class => MockResponse::make([
            'data' => [
                0 => [
                    'type' => 'entrySuggestions',
                    'id' => 'mock-id-1',
                    'attributes' => [
                        'ticketId' => 'mock-id-123',
                        'ticketNumber' => 'Mock value',
                        'customerId' => 'mock-id-123',
                        'userId' => 'mock-id-123',
                        'date' => 'Mock value',
                        'ticketTitle' => 'Mock value',
                        'ticketType' => 'Mock value',
                        'budgetId' => 'mock-id-123',
                    ],
                ],
                1 => [
                    'type' => 'entrySuggestions',
                    'id' => 'mock-id-2',
                    'attributes' => [
                        'ticketId' => 'mock-id-123',
                        'ticketNumber' => 'Mock value',
                        'customerId' => 'mock-id-123',
                        'userId' => 'mock-id-123',
                        'date' => 'Mock value',
                        'ticketTitle' => 'Mock value',
                        'ticketType' => 'Mock value',
                        'budgetId' => 'mock-id-123',
                    ],
                ],
            ],
        ], 200),
    ]);

    $request = (new GetEntrySuggestionsCollectionRequest)
        ->filter('date', 'test value');

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(function (GetEntrySuggestionsCollectionRequest $request) {
        $query = $request->query()->all();
        expect($query)->toHaveKey('filter[date]', 'test value');

        return true;
    });

    expect($response->status())->toBe(200);

    $dtoCollection = $response->dto();

    expect($dtoCollection->first())
        ->ticketId->toBe('mock-id-123')
        ->ticketNumber->toBe('Mock value')
        ->customerId->toBe('mock-id-123')
        ->userId->toBe('mock-id-123')
        ->date->toBe('Mock value')
        ->ticketTitle->toBe('Mock value')
        ->ticketType->toBe('Mock value')
        ->budgetId->toBe('mock-id-123');
});

it('calls the getEntrySuggestion method in the EntrySuggestion resource', function () {
    Saloon::fake([
        GetEntrySuggestionRequest::class => MockResponse::make([
            'data' => [
                'type' => 'entrySuggestions',
                'id' => 'mock-id-123',
                'attributes' => [
                    'ticketId' => 'mock-id-123',
                    'ticketNumber' => 'Mock value',
                    'customerId' => 'mock-id-123',
                    'userId' => 'mock-id-123',
                    'date' => 'Mock value',
                    'ticketTitle' => 'Mock value',
                    'ticketType' => 'Mock value',
                    'budgetId' => 'mock-id-123',
                ],
            ],
        ], 200),
    ]);

    $request = new GetEntrySuggestionRequest(
        entrySuggestionId: 'test string'
    );
    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetEntrySuggestionRequest::class);

    expect($response->status())->toBe(200);

    $dto = $response->dto();

    expect($dto)
        ->ticketId->toBe('mock-id-123')
        ->ticketNumber->toBe('Mock value')
        ->customerId->toBe('mock-id-123')
        ->userId->toBe('mock-id-123')
        ->date->toBe('Mock value')
        ->ticketTitle->toBe('Mock value')
        ->ticketType->toBe('Mock value')
        ->budgetId->toBe('mock-id-123');
});

it('calls the deleteEntrySuggestion method in the EntrySuggestion resource', function () {
    Saloon::fake([
        DeleteEntrySuggestionRequest::class => MockResponse::make([], 200),
    ]);

    $request = new DeleteEntrySuggestionRequest(
        entrySuggestionId: 'test string'
    );
    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(DeleteEntrySuggestionRequest::class);

    expect($response->status())->toBe(200);
});
