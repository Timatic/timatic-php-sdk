<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\TimeSpentTotal\GetTimeSpentTotalsRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the getTimeSpentTotals method in the TimeSpentTotal resource', function () {
    Saloon::fake([
        GetTimeSpentTotalsRequest::class => MockResponse::fixture('timeSpentTotal.getTimeSpentTotals'),
    ]);

    $response = $this->timaticConnector->timeSpentTotal()->getTimeSpentTotals(
        filterstartedAtgte: 'test string',
        filterstartedAtlte: 'test string',
        filterteamId: 'test string',
        filterteamIdeq: 'test string',
        filteruserId: 'test string',
        filteruserIdeq: 'test string'
    );

    Saloon::assertSent(GetTimeSpentTotalsRequest::class);

    expect($response->status())->toBe(200);
});
