<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\MarkAsExported\PostOvertimeMarkAsExportedRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the postOvertimeMarkAsExported method in the MarkAsExported resource', function () {
    $mockClient = Saloon::fake([
        PostOvertimeMarkAsExportedRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = new \Timatic\SDK\Dto\MarkAsExported;
    $dto->entryId = 'entry_id-123';
    $dto->overtimeTypeId = 'overtime_type_id-123';
    $dto->startedAt = \Carbon\Carbon::parse('2025-01-15T10:30:00Z');
    $dto->endedAt = \Carbon\Carbon::parse('2025-01-15T10:30:00Z');

    $this->timaticConnector->markAsExported()->postOvertimeMarkAsExported(overtimeId: 'test string', data: $dto);
    Saloon::assertSent(PostOvertimeMarkAsExportedRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('markAsExporteds')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->entryId->toBe('entry_id-123')
            ->overtimeTypeId->toBe('overtime_type_id-123')
            ->startedAt->toEqual(new \Carbon\Carbon('2025-01-15T10:30:00Z'))
            ->endedAt->toEqual(new \Carbon\Carbon('2025-01-15T10:30:00Z'))
            );

        return true;
    });
});
