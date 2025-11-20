<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\Overtime\GetOvertimesRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the getOvertimes method in the Overtime resource', function () {
    Saloon::fake([
        GetOvertimesRequest::class => MockResponse::fixture('overtime.getOvertimes'),
    ]);

    $response = $this->timaticConnector->overtime()->getOvertimes(
        filterstartedAt: 'test string',
        filterstartedAteq: 'test string',
        filterstartedAtnq: 'test string',
        filterstartedAtgt: 'test string',
        filterstartedAtlt: 'test string',
        filterstartedAtgte: 'test string',
        filterstartedAtlte: 'test string',
        filterstartedAtcontains: 'test string',
        filterendedAt: 'test string',
        filterendedAteq: 'test string',
        filterendedAtnq: 'test string',
        filterendedAtgt: 'test string',
        filterendedAtlt: 'test string',
        filterendedAtgte: 'test string',
        filterendedAtlte: 'test string',
        filterendedAtcontains: 'test string',
        filterisApproved: 'test string',
        filterapprovedAt: 'test string',
        filterapprovedAteq: 'test string',
        filterapprovedAtnq: 'test string',
        filterapprovedAtgt: 'test string',
        filterapprovedAtlt: 'test string',
        filterapprovedAtgte: 'test string',
        filterapprovedAtlte: 'test string',
        filterapprovedAtcontains: 'test string',
        filterisExported: 'test string'
    );

    Saloon::assertSent(GetOvertimesRequest::class);

    expect($response->status())->toBe(200);
});
