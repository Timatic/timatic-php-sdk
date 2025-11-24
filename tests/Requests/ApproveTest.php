<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\Approve\PostOvertimeApproveRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the postOvertimeApprove method in the Approve resource', function () {
    $mockClient = Saloon::fake([
        PostOvertimeApproveRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = new \Timatic\SDK\Dto\Approve;
    $dto->entryId = 'entry_id-123';
    $dto->overtimeTypeId = 'overtime_type_id-123';
    $dto->startedAt = \Carbon\Carbon::parse('2025-01-15T10:30:00Z');
    $dto->endedAt = \Carbon\Carbon::parse('2025-01-15T10:30:00Z');

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
