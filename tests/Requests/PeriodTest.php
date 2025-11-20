<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\Period\GetBudgetPeriodsRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the getBudgetPeriods method in the Period resource', function () {
    Saloon::fake([
        GetBudgetPeriodsRequest::class => MockResponse::fixture('period.getBudgetPeriods'),
    ]);

    $response = $this->timaticConnector->period()->getBudgetPeriods(
        budget: 'test string'
    );

    Saloon::assertSent(GetBudgetPeriodsRequest::class);

    expect($response->status())->toBe(200);
});
