<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\Event\PostEventsRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the postEvents method in the Event resource', function () {
    Saloon::fake([
        PostEventsRequest::class => MockResponse::make([], 200),
    ]);

    $response = $this->timaticConnector->event()->postEvents(

    );

    Saloon::assertSent(PostEventsRequest::class);

    expect($response->status())->toBe(200);
});
