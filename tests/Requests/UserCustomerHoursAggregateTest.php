<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\UserCustomerHoursAggregate\GetUserCustomerHoursAggregatesRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the getUserCustomerHoursAggregates method in the UserCustomerHoursAggregate resource', function () {
    Saloon::fake([
        GetUserCustomerHoursAggregatesRequest::class => MockResponse::make([
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

    $request = (new GetUserCustomerHoursAggregatesRequest)
        ->filter('startedAt', '2025-01-01')
        ->filter('endedAt', '2025-01-01')
        ->filter('teamId', 'test-id-123');

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetUserCustomerHoursAggregatesRequest::class);

    // Verify filter query parameters are present
    Saloon::assertSent(function (Request $request) {
        $query = $request->query()->all();

        expect($query)->toHaveKey('filter[startedAt]', '2025-01-01');
        expect($query)->toHaveKey('filter[endedAt]', '2025-01-01');
        expect($query)->toHaveKey('filter[teamId]', 'test-id-123');

        return true;
    });

    expect($response->status())->toBe(200);
});
