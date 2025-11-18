<?php

// Generated 2025-11-18 09:03:31

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\MarkAsExported\PostOvertimeMarkAsExportedRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the postOvertimeMarkAsExported method in the MarkAsExported resource', function () {
    Saloon::fake([
        PostOvertimeMarkAsExportedRequest::class => MockResponse::fixture('markAsExported.postOvertimeMarkAsExported'),
    ]);

    $response = $this->timaticConnector->markAsExported()->postOvertimeMarkAsExported(
        overtime: 'test string'
    );

    Saloon::assertSent(PostOvertimeMarkAsExportedRequest::class);

    expect($response->status())->toBe(200);
});
