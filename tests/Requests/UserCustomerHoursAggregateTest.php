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
                        'customerId' => 'mock-id-123',
                        'userId' => 'mock-id-123',
                        'internalMinutes' => 42,
                        'budgetMinutes' => 42,
                        'paidPerHourMinutes' => 42,
                    ],
                ],
                1 => [
                    'type' => 'resources',
                    'id' => 'mock-id-2',
                    'attributes' => [
                        'customerId' => 'mock-id-123',
                        'userId' => 'mock-id-123',
                        'internalMinutes' => 42,
                        'budgetMinutes' => 42,
                        'paidPerHourMinutes' => 42,
                    ],
                ],
            ],
        ], 200),
    ]);

    $request = (new GetUserCustomerHoursAggregatesRequest)
        ->filter('startedAt', '2025-01-01T10:00:00Z')
        ->filter('endedAt', '2025-01-01T10:00:00Z')
        ->filter('teamId', 'test-id-123');

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetUserCustomerHoursAggregatesRequest::class);

    // Verify filter query parameters are present
    Saloon::assertSent(function (Request $request) {
        $query = $request->query()->all();

        expect($query)->toHaveKey('filter[startedAt]', '2025-01-01T10:00:00Z');
        expect($query)->toHaveKey('filter[endedAt]', '2025-01-01T10:00:00Z');
        expect($query)->toHaveKey('filter[teamId]', 'test-id-123');

        return true;
    });

    expect($response->status())->toBe(200);

    $dtoCollection = $response->dto();

    expect($dtoCollection->first())
        ->customerId->toBe('mock-id-123')
        ->userId->toBe('mock-id-123')
        ->internalMinutes->toBe(42)
        ->budgetMinutes->toBe(42)
        ->paidPerHourMinutes->toBe(42);
});
