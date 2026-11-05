<?php

// auto-generated

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Requests\Ticket\TicketsCollectionRequest;
use Timatic\Requests\Ticket\TicketsShowRequest;
use Timatic\TimaticConnector;

beforeEach(function () {
    $this->timaticConnector = new TimaticConnector;
});

it('calls the ticketsCollection method in the Ticket resource', function () {
    Saloon::fake([
        TicketsCollectionRequest::class => MockResponse::make([
            'data' => [
                0 => [
                    'type' => 'tickets',
                    'id' => 'mock-id-1',
                    'attributes' => [
                        'key' => 'String value',
                        'title' => 'String value',
                        'closedAt' => 'String value',
                        'url' => 'String value',
                        'customerId' => 42,
                        'budgetId' => 42,
                    ],
                ],
                1 => [
                    'type' => 'tickets',
                    'id' => 'mock-id-2',
                    'attributes' => [
                        'key' => 'String value',
                        'title' => 'String value',
                        'closedAt' => 'String value',
                        'url' => 'String value',
                        'customerId' => 42,
                        'budgetId' => 42,
                    ],
                ],
            ],
        ], 200),
    ]);

    $request = (new TicketsCollectionRequest(pagesize: 123))
        ->filter('customerId', 'customer_id-123')
        ->filter('search', 'test value');

    $dtoCollection = $this->timaticConnector->paginate($request)->dtoCollection();

    Saloon::assertSent(function (TicketsCollectionRequest $request) {
        $query = $request->query()->all();
        expect($query)->toHaveKey('filter[customerId]', 'customer_id-123');
        expect($query)->toHaveKey('filter[search]', 'test value');

        return true;
    });

    expect($dtoCollection)->toHaveCount(2);

    expect($dtoCollection->first())
        ->key->toBe('String value')
        ->title->toBe('String value')
        ->closedAt->toBe('String value')
        ->url->toBe('String value')
        ->customerId->toBe(42)
        ->budgetId->toBe(42);
});

it('calls the ticketsShow method in the Ticket resource', function () {
    Saloon::fake([
        TicketsShowRequest::class => MockResponse::make([
            'data' => [
                'type' => 'tickets',
                'id' => 'mock-id-123',
                'attributes' => [
                    'key' => 'String value',
                    'title' => 'String value',
                    'closedAt' => 'String value',
                    'url' => 'String value',
                    'customerId' => 42,
                    'budgetId' => 42,
                ],
            ],
        ], 200),
    ]);

    $request = new TicketsShowRequest(
        keyId: 'test string'
    );
    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(TicketsShowRequest::class);

    expect($response->status())->toBe(200);

    $dto = $response->dto();

    expect($dto)
        ->key->toBe('String value')
        ->title->toBe('String value')
        ->closedAt->toBe('String value')
        ->url->toBe('String value')
        ->customerId->toBe(42)
        ->budgetId->toBe(42);
});
