<?php

// auto-generated

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Requests\Event\EventsStoreRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\TimaticConnector;
});

it('calls the eventsStore method in the Event resource', function () {
    $mockClient = Saloon::fake([
        EventsStoreRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = \Timatic\Dto\Event::factory()->state([
        'userId' => 42,
        'budgetId' => 42,
        'ticketId' => 'ticket_id-123',
        'sourceId' => 'source_id-123',
    ])->make();

    $request = new EventsStoreRequest($dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(EventsStoreRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('events')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->userId->toBe(42)
            ->budgetId->toBe(42)
            ->ticketId->toBe('ticket_id-123')
            ->sourceId->toBe('source_id-123')
            );

        return true;
    });
});
