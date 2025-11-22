<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\EntrySuggestion\DeleteEntrySuggestionRequest;
use Timatic\SDK\Requests\EntrySuggestion\GetEntrySuggestionRequest;
use Timatic\SDK\Requests\EntrySuggestion\GetEntrySuggestionsRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the getEntrySuggestions method in the EntrySuggestion resource', function () {
    Saloon::fake([
        GetEntrySuggestionsRequest::class => MockResponse::make([
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

    $request = (new GetEntrySuggestionsRequest)
        ->filter('date', 'test value');

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetEntrySuggestionsRequest::class);

    // Verify filter query parameters are present
    Saloon::assertSent(function (Request $request) {
        $query = $request->query()->all();

        expect($query)->toHaveKey('filter[date]', 'test value');

        return true;
    });

    expect($response->status())->toBe(200);
});

it('calls the getEntrySuggestion method in the EntrySuggestion resource', function () {
    Saloon::fake([
        GetEntrySuggestionRequest::class => MockResponse::make([
            'data' => [
                'type' => 'resources',
                'id' => 'mock-id-123',
                'attributes' => [
                    'name' => 'Mock value',
                ],
            ],
        ], 200),
    ]);

    $response = $this->timaticConnector->entrySuggestion()->getEntrySuggestion(
        entrySuggestionId: 'test string'
    );

    Saloon::assertSent(GetEntrySuggestionRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the deleteEntrySuggestion method in the EntrySuggestion resource', function () {
    Saloon::fake([
        DeleteEntrySuggestionRequest::class => MockResponse::make([], 200),
    ]);

    $response = $this->timaticConnector->entrySuggestion()->deleteEntrySuggestion(
        entrySuggestionId: 'test string'
    );

    Saloon::assertSent(DeleteEntrySuggestionRequest::class);

    expect($response->status())->toBe(200);
});
