<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\Me\GetMesRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the getMes method in the Me resource', function () {
    Saloon::fake([
        GetMesRequest::class => MockResponse::make([
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

    $request = (new GetMesRequest);

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetMesRequest::class);

    expect($response->status())->toBe(200);
});
