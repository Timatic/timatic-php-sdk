<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\Overtime\GetOvertimesRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the getOvertimes method in the Overtime resource', function () {
    Saloon::fake([
        GetOvertimesRequest::class => MockResponse::make([
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

    $request = (new GetOvertimesRequest)
        ->filter('startedAt', '2025-01-01T10:00:00Z')
        ->filter('endedAt', '2025-01-01T10:00:00Z')
        ->filter('isApproved', false);

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetOvertimesRequest::class);

    // Verify filter query parameters are present
    Saloon::assertSent(function (Request $request) {
        $query = $request->query()->all();

        expect($query)->toHaveKey('filter[startedAt]', '2025-01-01T10:00:00Z');
        expect($query)->toHaveKey('filter[endedAt]', '2025-01-01T10:00:00Z');
        expect($query)->toHaveKey('filter[isApproved]', false);

        return true;
    });

    expect($response->status())->toBe(200);
});
