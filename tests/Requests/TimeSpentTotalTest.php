<?php

use Carbon\Carbon;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\TimeSpentTotal\GetTimeSpentTotalsRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the getTimeSpentTotals method in the TimeSpentTotal resource', function () {
    Saloon::fake([
        GetTimeSpentTotalsRequest::class => MockResponse::make([
            'data' => [
                0 => [
                    'type' => 'timeSpentTotals',
                    'id' => 'mock-id-1',
                    'attributes' => [
                        'start' => '2025-11-22T10:40:04.065Z',
                        'end' => '2025-11-22T10:40:04.065Z',
                        'internalMinutes' => 42,
                        'billableMinutes' => 42,
                        'periodUnit' => 'Mock value',
                        'periodValue' => 42,
                    ],
                ],
                1 => [
                    'type' => 'timeSpentTotals',
                    'id' => 'mock-id-2',
                    'attributes' => [
                        'start' => '2025-11-22T10:40:04.065Z',
                        'end' => '2025-11-22T10:40:04.065Z',
                        'internalMinutes' => 42,
                        'billableMinutes' => 42,
                        'periodUnit' => 'Mock value',
                        'periodValue' => 42,
                    ],
                ],
            ],
        ], 200),
    ]);

    $request = (new GetTimeSpentTotalsRequest)
        ->filter('teamId', 'team_id-123')
        ->filter('userId', 'user_id-123');

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetTimeSpentTotalsRequest::class);

    // Verify filter query parameters are present
    Saloon::assertSent(function (Request $request) {
        $query = $request->query()->all();

        expect($query)->toHaveKey('filter[teamId]', 'team_id-123');
        expect($query)->toHaveKey('filter[userId]', 'user_id-123');

        return true;
    });

    expect($response->status())->toBe(200);

    $dtoCollection = $response->dto();

    expect($dtoCollection->first())
        ->start->toEqual(new Carbon('2025-11-22T10:40:04.065Z'))
        ->end->toEqual(new Carbon('2025-11-22T10:40:04.065Z'))
        ->internalMinutes->toBe(42)
        ->billableMinutes->toBe(42)
        ->periodUnit->toBe('Mock value')
        ->periodValue->toBe(42);
});
