<?php

// Generated 2025-11-18 09:03:31

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\Number\GetIncidentsNumberRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the getIncidentsNumber method in the Number resource', function () {
    Saloon::fake([
        GetIncidentsNumberRequest::class => MockResponse::fixture('number.getIncidentsNumber'),
    ]);

    $response = $this->timaticConnector->number()->getIncidentsNumber(
        incident: 'test string'
    );

    Saloon::assertSent(GetIncidentsNumberRequest::class);

    expect($response->status())->toBe(200);
});
