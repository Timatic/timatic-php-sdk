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
                        'entryId' => 'mock-id-123',
                        'overtimeTypeId' => 'mock-id-123',
                        'startedAt' => 'Mock value',
                        'endedAt' => 'Mock value',
                        'percentages' => 'Mock value',
                        'approvedAt' => 'Mock value',
                        'approvedByUserId' => 'mock-id-123',
                        'exportedAt' => 'Mock value',
                    ],
                ],
                1 => [
                    'type' => 'resources',
                    'id' => 'mock-id-2',
                    'attributes' => [
                        'entryId' => 'mock-id-123',
                        'overtimeTypeId' => 'mock-id-123',
                        'startedAt' => 'Mock value',
                        'endedAt' => 'Mock value',
                        'percentages' => 'Mock value',
                        'approvedAt' => 'Mock value',
                        'approvedByUserId' => 'mock-id-123',
                        'exportedAt' => 'Mock value',
                    ],
                ],
            ],
        ], 200),
    ]);

    $request = (new GetOvertimesRequest)
        ->filter('startedAt', '2025-01-15T10:30:00Z')
        ->filter('endedAt', '2025-01-15T10:30:00Z')
        ->filter('isApproved', true);

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetOvertimesRequest::class);

    // Verify filter query parameters are present
    Saloon::assertSent(function (Request $request) {
        $query = $request->query()->all();

        expect($query)->toHaveKey('filter[startedAt]', '2025-01-15T10:30:00Z');
        expect($query)->toHaveKey('filter[endedAt]', '2025-01-15T10:30:00Z');
        expect($query)->toHaveKey('filter[isApproved]', true);

        return true;
    });

    expect($response->status())->toBe(200);

    $dtoCollection = $response->dto();

    expect($dtoCollection->first())
        ->entryId->toBe('mock-id-123')
        ->overtimeTypeId->toBe('mock-id-123')
        ->startedAt->toBe('Mock value')
        ->endedAt->toBe('Mock value')
        ->percentages->toBe('Mock value')
        ->approvedAt->toBe('Mock value')
        ->approvedByUserId->toBe('mock-id-123')
        ->exportedAt->toBe('Mock value');
});
