<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\DailyProgress\GetDailyProgressesRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the getDailyProgresses method in the DailyProgress resource', function () {
    Saloon::fake([
        GetDailyProgressesRequest::class => MockResponse::make([
            'data' => [
                0 => [
                    'type' => 'resources',
                    'id' => 'mock-id-1',
                    'attributes' => [
                        'data' => [],
                    ],
                ],
                1 => [
                    'type' => 'resources',
                    'id' => 'mock-id-2',
                    'attributes' => [
                        'data' => [],
                    ],
                ],
            ],
        ], 200),
    ]);

    $request = (new GetDailyProgressesRequest);

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetDailyProgressesRequest::class);

    expect($response->status())->toBe(200);
});
