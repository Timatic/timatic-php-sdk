<?php

// auto-generated

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Requests\MarkAsInvoiced\PostEntryMarkAsInvoicedRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\TimaticConnector;
});

it('calls the postEntryMarkAsInvoiced method in the MarkAsInvoiced resource', function () {
    $mockClient = Saloon::fake([
        PostEntryMarkAsInvoicedRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = \Timatic\Dto\MarkAsInvoiced::factory()->state([
        'ticketId' => 'ticket_id-123',
        'ticketNumber' => 'test value',
        'ticketTitle' => 'test value',
        'ticketType' => 'test value',
    ])->make();

    $request = new PostEntryMarkAsInvoicedRequest(entryId: 'test string', data: $dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(PostEntryMarkAsInvoicedRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('markAsInvoiceds')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->ticketId->toBe('ticket_id-123')
            ->ticketNumber->toBe('test value')
            ->ticketTitle->toBe('test value')
            ->ticketType->toBe('test value')
            );

        return true;
    });
});
