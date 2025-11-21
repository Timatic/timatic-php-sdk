<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\MarkAsExported\PostOvertimeMarkAsExportedRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the postOvertimeMarkAsExported method in the MarkAsExported resource', function () {
    Saloon::fake([
        PostOvertimeMarkAsExportedRequest::class => MockResponse::make([], 200),
    ]);

    $response = $this->timaticConnector->markAsExported()->postOvertimeMarkAsExported(
        overtimeId: 'test string'
    );

    Saloon::assertSent(PostOvertimeMarkAsExportedRequest::class);

    expect($response->status())->toBe(200);
});
