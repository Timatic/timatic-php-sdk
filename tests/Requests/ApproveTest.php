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
    $dto->entryId = 'mock-id-123';
    $dto->overtimeTypeId = 'mock-id-123';
    $dto->startedAt = 'test value';
    $dto->endedAt = 'test value';
    // todo: add every other DTO field

    $this->timaticConnector->approve()->postOvertimeApprove(overtimeId: 'test string', $dto);
    Saloon::assertSent(PostOvertimeApproveRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            // POST calls dont have an ID field
            ->data->type->toBe('approve')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->entryId->toBe('mock-id-123')
            ->overtimeTypeId->toBe('mock-id-123')
            ->startedAt->toBe('test value')
            ->endedAt->toBe('test value')
            );

        return true;
    });
});
