<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\Period\GetBudgetPeriodsRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the getBudgetPeriods method in the Period resource', function () {
    Saloon::fake([
        GetBudgetPeriodsRequest::class => MockResponse::make([
            'data' => [
                'type' => 'resources',
                'id' => 'mock-id-123',
                'attributes' => [
                    'name' => 'Mock value',
                ],
            ],
        ], 200),
    ]);

    $response = $this->timaticConnector->period()->getBudgetPeriods(
        budgetId: 'test string'
    );

    Saloon::assertSent(GetBudgetPeriodsRequest::class);

    expect($response->status())->toBe(200);
});
