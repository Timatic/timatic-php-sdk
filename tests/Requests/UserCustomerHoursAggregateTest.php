<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\UserCustomerHoursAggregate\GetUserCustomerHoursAggregatesRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the getUserCustomerHoursAggregates method in the UserCustomerHoursAggregate resource', function () {
    Saloon::fake([
        GetUserCustomerHoursAggregatesRequest::class => MockResponse::fixture('userCustomerHoursAggregate.getUserCustomerHoursAggregates'),
    ]);

    $response = $this->timaticConnector->userCustomerHoursAggregate()->getUserCustomerHoursAggregates(
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
        filterteamId: 'test string',
        filterteamIdeq: 'test string',
        filterteamIdnq: 'test string',
        filterteamIdgt: 'test string',
        filterteamIdlt: 'test string',
        filterteamIdgte: 'test string',
        filterteamIdlte: 'test string',
        filterteamIdcontains: 'test string',
        filteruserId: 'test string',
        filteruserIdeq: 'test string',
        filteruserIdnq: 'test string',
        filteruserIdgt: 'test string',
        filteruserIdlt: 'test string',
        filteruserIdgte: 'test string',
        filteruserIdlte: 'test string',
        filteruserIdcontains: 'test string'
    );

    Saloon::assertSent(GetUserCustomerHoursAggregatesRequest::class);

    expect($response->status())->toBe(200);
});
