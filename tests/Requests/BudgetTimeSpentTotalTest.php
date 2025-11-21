<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\BudgetTimeSpentTotal\GetBudgetTimeSpentTotalsRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the getBudgetTimeSpentTotals method in the BudgetTimeSpentTotal resource', function () {
    Saloon::fake([
        GetBudgetTimeSpentTotalsRequest::class => MockResponse::fixture('budgetTimeSpentTotal.getBudgetTimeSpentTotals'),
    ]);

    $request = (new GetBudgetTimeSpentTotalsRequest)
        ->filter('budgetId', 'test-id-123');

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetBudgetTimeSpentTotalsRequest::class);

    // Verify filter query parameters are present
    Saloon::assertSent(function (Request $request) {
        $query = $request->query()->all();

        expect($query)->toHaveKey('filter[budgetId]', 'test-id-123');

        return true;
    });

    expect($response->status())->toBe(200);
});
