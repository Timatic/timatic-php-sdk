<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\ExportMail\GetBudgetsExportMailsRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the getBudgetsExportMails method in the ExportMail resource', function () {
    Saloon::fake([
        GetBudgetsExportMailsRequest::class => MockResponse::make([
            'data' => [
                0 => [
                    'type' => 'resources',
                    'id' => 'mock-id-1',
                    'attributes' => [
                        'name' => 'Mock value',
                    ],
                ],
                1 => [
                    'type' => 'resources',
                    'id' => 'mock-id-2',
                    'attributes' => [
                        'name' => 'Mock value',
                    ],
                ],
            ],
        ], 200),
    ]);

    $request = (new GetBudgetsExportMailsRequest);

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetBudgetsExportMailsRequest::class);

    expect($response->status())->toBe(200);
});
