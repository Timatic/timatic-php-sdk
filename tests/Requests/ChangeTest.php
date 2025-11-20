<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\Change\GetChangeRequest;
use Timatic\SDK\Requests\Change\GetChangesRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the getChange method in the Change resource', function () {
    Saloon::fake([
        GetChangeRequest::class => MockResponse::fixture('change.getChange'),
    ]);

    $response = $this->timaticConnector->change()->getChange(
        change: 'test string'
    );

    Saloon::assertSent(GetChangeRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the getChanges method in the Change resource', function () {
    Saloon::fake([
        GetChangesRequest::class => MockResponse::fixture('change.getChanges'),
    ]);

    $response = $this->timaticConnector->change()->getChanges(

    );

    Saloon::assertSent(GetChangesRequest::class);

    expect($response->status())->toBe(200);
});
