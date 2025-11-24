<?php

use Carbon\Carbon;
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
                    'type' => 'overtimes',
                    'id' => 'mock-id-1',
                    'attributes' => [
                        'entryId' => 'mock-id-123',
                        'overtimeTypeId' => 'mock-id-123',
                        'startedAt' => '2025-11-22T10:40:04.065Z',
                        'endedAt' => '2025-11-22T10:40:04.065Z',
                        'percentages' => 'Mock value',
                        'approvedAt' => '2025-11-22T10:40:04.065Z',
                        'approvedByUserId' => 'mock-id-123',
                        'exportedAt' => '2025-11-22T10:40:04.065Z',
                    ],
                ],
                1 => [
                    'type' => 'overtimes',
                    'id' => 'mock-id-2',
                    'attributes' => [
                        'entryId' => 'mock-id-123',
                        'overtimeTypeId' => 'mock-id-123',
                        'startedAt' => '2025-11-22T10:40:04.065Z',
                        'endedAt' => '2025-11-22T10:40:04.065Z',
                        'percentages' => 'Mock value',
                        'approvedAt' => '2025-11-22T10:40:04.065Z',
                        'approvedByUserId' => 'mock-id-123',
                        'exportedAt' => '2025-11-22T10:40:04.065Z',
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
        ->startedAt->toEqual(new Carbon('2025-11-22T10:40:04.065Z'))
        ->endedAt->toEqual(new Carbon('2025-11-22T10:40:04.065Z'))
        ->percentages->toBe('Mock value')
        ->approvedAt->toEqual(new Carbon('2025-11-22T10:40:04.065Z'))
        ->approvedByUserId->toBe('mock-id-123')
        ->exportedAt->toEqual(new Carbon('2025-11-22T10:40:04.065Z'));
});
