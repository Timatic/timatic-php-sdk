<?php

// Generated 2025-11-17 21:22:04

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\ExportMail\GetBudgetsExportMailsRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the getBudgetsExportMails method in the ExportMail resource', function () {
    Saloon::fake([
        GetBudgetsExportMailsRequest::class => MockResponse::fixture('exportMail.getBudgetsExportMails'),
    ]);

    $response = $this->timaticConnector->exportMail()->getBudgetsExportMails(

    );

    Saloon::assertSent(GetBudgetsExportMailsRequest::class);

    expect($response->status())->toBe(200);
});
