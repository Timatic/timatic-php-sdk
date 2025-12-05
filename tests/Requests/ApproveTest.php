<?php

// auto-generated

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Requests\Approve\PostOvertimeApproveRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\TimaticConnector;
});

it('calls the postOvertimeApprove method in the Approve resource', function () {
    $mockClient = Saloon::fake([
        PostOvertimeApproveRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = \Timatic\Dto\Approve::factory()->state([
        'entryId' => 'entry_id-123',
        'overtimeTypeId' => 'overtime_type_id-123',
        'startedAt' => \Carbon\Carbon::parse('2025-01-15T10:30:00Z'),
        'endedAt' => \Carbon\Carbon::parse('2025-01-15T10:30:00Z'),
    ])->make();

    $request = new PostOvertimeApproveRequest(overtimeId: 'test string', data: $dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(PostOvertimeApproveRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('approves')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->entryId->toBe('entry_id-123')
            ->overtimeTypeId->toBe('overtime_type_id-123')
            ->startedAt->toEqual(new \Carbon\Carbon('2025-01-15T10:30:00Z'))
            ->endedAt->toEqual(new \Carbon\Carbon('2025-01-15T10:30:00Z'))
            );

        return true;
    });
});
