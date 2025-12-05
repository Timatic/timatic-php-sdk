<?php

// auto-generated

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Requests\MarkAsExported\PostOvertimeMarkAsExportedRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\TimaticConnector;
});

it('calls the postOvertimeMarkAsExported method in the MarkAsExported resource', function () {
    $mockClient = Saloon::fake([
        PostOvertimeMarkAsExportedRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = \Timatic\Dto\MarkAsExported::factory()->state([
        'entryId' => 'entry_id-123',
        'overtimeTypeId' => 'overtime_type_id-123',
        'startedAt' => \Carbon\Carbon::parse('2025-01-15T10:30:00Z'),
        'endedAt' => \Carbon\Carbon::parse('2025-01-15T10:30:00Z'),
    ])->make();

    $request = new PostOvertimeMarkAsExportedRequest(overtimeId: 'test string', data: $dto);
    $this->timaticConnector->send($request);

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
