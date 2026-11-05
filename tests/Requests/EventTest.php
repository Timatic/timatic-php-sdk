<?php

// auto-generated

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Dto\Event;
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
    $dto = Event::testFactory()->state([
        'name' => 'test value',
    ])->make();

    $request = new EventsStoreRequest($dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(EventsStoreRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('events');

        return true;
    });
});
