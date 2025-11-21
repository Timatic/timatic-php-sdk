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
        GetBudgetTimeSpentTotalsRequest::class => MockResponse::make([
            'data' => [
                0 => [
                    'type' => 'resources',
                    'id' => 'mock-id-1',
                    'attributes' => [
                        'data' => [],
                    ],
                ],
                1 => [
                    'type' => 'resources',
                    'id' => 'mock-id-2',
                    'attributes' => [
                        'data' => [],
                    ],
                ],
            ],
        ], 200),
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
