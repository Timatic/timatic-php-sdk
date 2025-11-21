<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\TimeSpentTotal\GetTimeSpentTotalsRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the getTimeSpentTotals method in the TimeSpentTotal resource', function () {
    Saloon::fake([
        GetTimeSpentTotalsRequest::class => MockResponse::fixture('timeSpentTotal.getTimeSpentTotals'),
    ]);

    $request = (new GetTimeSpentTotalsRequest)
        ->filter('teamId', 'test-id-123')
        ->filter('userId', 'test-id-123');

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetTimeSpentTotalsRequest::class);

    // Verify filter query parameters are present
    Saloon::assertSent(function (Request $request) {
        $query = $request->query()->all();

        expect($query)->toHaveKey('filter[teamId]', 'test-id-123');
        expect($query)->toHaveKey('filter[userId]', 'test-id-123');

        return true;
    });

    expect($response->status())->toBe(200);
});
