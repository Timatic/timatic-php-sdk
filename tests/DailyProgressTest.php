<?php

// Generated 2025-11-17 21:22:04

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\DailyProgress\GetDailyProgressesRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the getDailyProgresses method in the DailyProgress resource', function () {
    Saloon::fake([
        GetDailyProgressesRequest::class => MockResponse::fixture('dailyProgress.getDailyProgresses'),
    ]);

    $response = $this->timaticConnector->dailyProgress()->getDailyProgresses(

    );

    Saloon::assertSent(GetDailyProgressesRequest::class);

    expect($response->status())->toBe(200);
});
