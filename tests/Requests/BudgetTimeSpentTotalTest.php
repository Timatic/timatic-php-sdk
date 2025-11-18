<?php

// Generated 2025-11-18 09:03:31

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\BudgetTimeSpentTotal\GetBudgetTimeSpentTotalsRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the getBudgetTimeSpentTotals method in the BudgetTimeSpentTotal resource', function () {
    Saloon::fake([
        GetBudgetTimeSpentTotalsRequest::class => MockResponse::fixture('budgetTimeSpentTotal.getBudgetTimeSpentTotals'),
    ]);

    $response = $this->timaticConnector->budgetTimeSpentTotal()->getBudgetTimeSpentTotals(
        filterbudgetId: 'test string',
        filterbudgetIdeq: 'test string'
    );

    Saloon::assertSent(GetBudgetTimeSpentTotalsRequest::class);

    expect($response->status())->toBe(200);
});
