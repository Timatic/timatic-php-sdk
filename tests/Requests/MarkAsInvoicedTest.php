<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\MarkAsInvoiced\PostEntryMarkAsInvoicedRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the postEntryMarkAsInvoiced method in the MarkAsInvoiced resource', function () {
    $mockClient = Saloon::fake([
        PostEntryMarkAsInvoicedRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = new \Timatic\SDK\Dto\MarkAsInvoiced;
    $dto->name = 'test value';
    // todo: add every other DTO field

    $this->timaticConnector->markAsInvoiced()->postEntryMarkAsInvoiced(entryId: 'test string', $dto);
    Saloon::assertSent(PostEntryMarkAsInvoicedRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            // POST calls dont have an ID field
            ->data->type->toBe('markAsInvoiced')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->name->toBe('test value')
            );

        return true;
    });
});
