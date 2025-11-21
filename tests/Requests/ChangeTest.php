<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\Change\GetChangeRequest;
use Timatic\SDK\Requests\Change\GetChangesRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the getChange method in the Change resource', function () {
    Saloon::fake([
        GetChangeRequest::class => MockResponse::make([
            'data' => [
                'type' => 'resources',
                'id' => 'mock-id-123',
                'attributes' => [
                    'name' => 'Mock value',
                ],
            ],
        ], 200),
    ]);

    $response = $this->timaticConnector->change()->getChange(
        changeId: 'test string'
    );

    Saloon::assertSent(GetChangeRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the getChanges method in the Change resource', function () {
    Saloon::fake([
        GetChangesRequest::class => MockResponse::make([
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

    $request = (new GetChangesRequest);

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetChangesRequest::class);

    expect($response->status())->toBe(200);
});
