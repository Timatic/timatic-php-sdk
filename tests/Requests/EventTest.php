<?php

// auto-generated

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Dto\EventRequest;
use Timatic\Requests\Event\EventsStoreRequest;
use Timatic\TimaticConnector;

beforeEach(function () {
    $this->timaticConnector = new TimaticConnector;
});

it('calls the eventsStore method in the Event resource', function () {
    $mockClient = Saloon::fake([
        EventsStoreRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = EventRequest::testFactory()->state([
        'sourceId' => 'source_id-123',
        'userId' => 42,
        'userExternalId' => 'user_external_id-123',
        'budgetId' => 42,
    ])->make();

    $request = new EventsStoreRequest($dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(EventsStoreRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('events')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->sourceId->toBe('source_id-123')
            ->userId->toBe(42)
            ->userExternalId->toBe('user_external_id-123')
            ->budgetId->toBe(42)
            );

        return true;
    });
});
