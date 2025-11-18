<?php

// Generated 2025-11-18 09:03:31

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\Event\PostEventsRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the postEvents method in the Event resource', function () {
    Saloon::fake([
        PostEventsRequest::class => MockResponse::fixture('event.postEvents'),
    ]);

    $response = $this->timaticConnector->event()->postEvents(

    );

    Saloon::assertSent(PostEventsRequest::class);

    expect($response->status())->toBe(200);
});
