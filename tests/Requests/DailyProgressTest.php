<?php

// auto-generated

use Carbon\Carbon;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Requests\DailyProgress\GetDailyProgressesRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\TimaticConnector;
});

it('calls the getDailyProgresses method in the DailyProgress resource', function () {
    Saloon::fake([
        GetDailyProgressesRequest::class => MockResponse::make([
            'data' => [
                0 => [
                    'type' => 'dailyProgresses',
                    'id' => 'mock-id-1',
                    'attributes' => [
                        'userId' => 'mock-id-123',
                        'date' => '2025-11-22T10:40:04.065Z',
                        'progress' => 'Mock value',
                    ],
                ],
                1 => [
                    'type' => 'dailyProgresses',
                    'id' => 'mock-id-2',
                    'attributes' => [
                        'userId' => 'mock-id-123',
                        'date' => '2025-11-22T10:40:04.065Z',
                        'progress' => 'Mock value',
                    ],
                ],
            ],
        ], 200),
    ]);

    $request = (new GetDailyProgressesRequest);

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetDailyProgressesRequest::class);

    expect($response->status())->toBe(200);

    $dtoCollection = $response->dto();

    expect($dtoCollection->first())
        ->userId->toBe('mock-id-123')
        ->date->toEqual(new Carbon('2025-11-22T10:40:04.065Z'))
        ->progress->toBe('Mock value');
});
