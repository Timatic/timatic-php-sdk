<?php

// Generated 2025-11-17 21:22:04

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\Me\GetMesRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the getMes method in the Me resource', function () {
    Saloon::fake([
        GetMesRequest::class => MockResponse::fixture('me.getMes'),
    ]);

    $response = $this->timaticConnector->me()->getMes(

    );

    Saloon::assertSent(GetMesRequest::class);

    expect($response->status())->toBe(200);
});
