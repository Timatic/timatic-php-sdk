<?php

// auto-generated

use Carbon\Carbon;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Dto\Entry;
use Timatic\Dto\Overtime;
use Timatic\Dto\OvertimeType;
use Timatic\Requests\Overtime\OvertimeApproveRequest;
use Timatic\Requests\Overtime\OvertimeMarkAsExportedRequest;
use Timatic\Requests\Overtime\OvertimesCollectionRequest;
use Timatic\TimaticConnector;

beforeEach(function () {
    $this->timaticConnector = new TimaticConnector;
});

it('calls the overtimesCollection method in the Overtime resource', function () {
    Saloon::fake([
        OvertimesCollectionRequest::class => MockResponse::make([
            'data' => [
                0 => [
                    'type' => 'overtimes',
                    'id' => 'mock-id-1',
                    'attributes' => [
                        'entryId' => 42,
                        'overtimeTypeId' => 'mock-id-123',
                        'startedAt' => '2025-11-22T10:40:04+00:00',
                        'endedAt' => '2025-11-22T10:40:04+00:00',
                        'percentages' => [],
                        'approvedAt' => '2025-11-22T10:40:04+00:00',
                        'approvedByUserId' => 42,
                        'exportedAt' => '2025-11-22T10:40:04+00:00',
                    ],
                    'relationships' => [
                        'overtimeType' => [
                            'data' => [
                                'type' => 'overtimetypes',
                                'id' => 'related-overtimeType-1',
                            ],
                        ],
                        'entry' => [
                            'data' => [
                                'type' => 'entries',
                                'id' => 'related-entry-1',
                            ],
                        ],
                    ],
                ],
                1 => [
                    'type' => 'overtimes',
                    'id' => 'mock-id-2',
                    'attributes' => [
                        'entryId' => 42,
                        'overtimeTypeId' => 'mock-id-123',
                        'startedAt' => '2025-11-22T10:40:04+00:00',
                        'endedAt' => '2025-11-22T10:40:04+00:00',
                        'percentages' => [],
                        'approvedAt' => '2025-11-22T10:40:04+00:00',
                        'approvedByUserId' => 42,
                        'exportedAt' => '2025-11-22T10:40:04+00:00',
                    ],
                    'relationships' => [
                        'overtimeType' => [
                            'data' => [
                                'type' => 'overtimetypes',
                                'id' => 'related-overtimeType-1',
                            ],
                        ],
                        'entry' => [
                            'data' => [
                                'type' => 'entries',
                                'id' => 'related-entry-1',
                            ],
                        ],
                    ],
                ],
            ],
            'included' => [
                0 => [
                    'type' => 'overtimetypes',
                    'id' => 'related-overtimeType-1',
                    'attributes' => [],
                ],
                1 => [
                    'type' => 'entries',
                    'id' => 'related-entry-1',
                    'attributes' => [],
                ],
            ],
        ], 200),
    ]);

    $request = (new OvertimesCollectionRequest(pagesize: 123, pagenumber: 123))
        ->filter('startedAt', '2025-01-15T10:30:00Z')
        ->filter('endedAt', '2025-01-15T10:30:00Z')
        ->filter('isApproved', true)
        ->includeOvertimeType()
        ->includeEntry();

    $dtoCollection = $this->timaticConnector->paginate($request)->dtoCollection();

    Saloon::assertSent(function (OvertimesCollectionRequest $request) {
        $query = $request->query()->all();
        expect($query)->toHaveKey('filter[startedAt]', '2025-01-15T10:30:00Z');
        expect($query)->toHaveKey('filter[endedAt]', '2025-01-15T10:30:00Z');
        expect($query)->toHaveKey('filter[isApproved]', true);
        expect($query)->toHaveKey('include', 'overtimeType,entry');

        return true;
    });

    expect($dtoCollection)->toHaveCount(2);

    expect($dtoCollection->first())
        ->entryId->toBe(42)
        ->overtimeTypeId->toBe('mock-id-123')
        ->startedAt->toEqual(new Carbon('2025-11-22T10:40:04+00:00'))
        ->endedAt->toEqual(new Carbon('2025-11-22T10:40:04+00:00'))
        ->approvedAt->toEqual(new Carbon('2025-11-22T10:40:04+00:00'))
        ->approvedByUserId->toBe(42)
        ->exportedAt->toEqual(new Carbon('2025-11-22T10:40:04+00:00'))
        ->overtimeType->toBeInstanceOf(OvertimeType::class)
        ->entry->toBeInstanceOf(Entry::class);
});

it('calls the overtimeApprove method in the Overtime resource', function () {
    $mockClient = Saloon::fake([
        OvertimeApproveRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = Overtime::testFactory()->state([
        'entryId' => 42,
    ])->make();

    $request = new OvertimeApproveRequest(overtimeId: 42, data: $dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(OvertimeApproveRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('overtimes')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->entryId->toBe(42)
            );

        return true;
    });
});

it('calls the overtimeMarkAsExported method in the Overtime resource', function () {
    $mockClient = Saloon::fake([
        OvertimeMarkAsExportedRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = Overtime::testFactory()->state([
        'entryId' => 42,
    ])->make();

    $request = new OvertimeMarkAsExportedRequest(overtimeId: 42, data: $dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(OvertimeMarkAsExportedRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('overtimes')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->entryId->toBe(42)
            );

        return true;
    });
});
