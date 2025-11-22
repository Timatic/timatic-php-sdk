<?php

use Carbon\Carbon;
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
                        'start' => '2025-11-22T10:40:04.065Z',
                        'end' => '2025-11-22T10:40:04.065Z',
                        'remainingMinutes' => 42,
                        'periodUnit' => 'Mock value',
                        'periodValue' => 42,
                    ],
                ],
                1 => [
                    'type' => 'resources',
                    'id' => 'mock-id-2',
                    'attributes' => [
                        'start' => '2025-11-22T10:40:04.065Z',
                        'end' => '2025-11-22T10:40:04.065Z',
                        'remainingMinutes' => 42,
                        'periodUnit' => 'Mock value',
                        'periodValue' => 42,
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

    $dtoCollection = $response->dto();

    expect($dtoCollection->first())
        ->start->toEqual(new Carbon('2025-11-22T10:40:04.065Z'))
        ->end->toEqual(new Carbon('2025-11-22T10:40:04.065Z'))
        ->remainingMinutes->toBe(42)
        ->periodUnit->toBe('Mock value')
        ->periodValue->toBe(42);
});
