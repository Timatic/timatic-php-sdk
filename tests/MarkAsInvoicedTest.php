<?php

// Generated 2025-11-17 21:22:04

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\MarkAsInvoiced\PostEntryMarkAsInvoicedRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the postEntryMarkAsInvoiced method in the MarkAsInvoiced resource', function () {
    Saloon::fake([
        PostEntryMarkAsInvoicedRequest::class => MockResponse::fixture('markAsInvoiced.postEntryMarkAsInvoiced'),
    ]);

    $response = $this->timaticConnector->markAsInvoiced()->postEntryMarkAsInvoiced(
        entry: 'test string'
    );

    Saloon::assertSent(PostEntryMarkAsInvoicedRequest::class);

    expect($response->status())->toBe(200);
});
