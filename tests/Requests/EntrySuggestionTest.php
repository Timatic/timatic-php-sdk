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
        GetEntrySuggestionsRequest::class => MockResponse::fixture('entrySuggestion.getEntrySuggestions'),
    ]);

    $request = (new GetEntrySuggestionsRequest)
        ->filter('date', 'test-value');

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetEntrySuggestionsRequest::class);

    // Verify filter query parameters are present
    Saloon::assertSent(function (Request $request) {
        $query = $request->query()->all();

        expect($query)->toHaveKey('filter[date]', 'test-value');

        return true;
    });

    expect($response->status())->toBe(200);
});

it('calls the getEntrySuggestion method in the EntrySuggestion resource', function () {
    Saloon::fake([
        GetEntrySuggestionRequest::class => MockResponse::fixture('entrySuggestion.getEntrySuggestion'),
    ]);

    $response = $this->timaticConnector->entrySuggestion()->getEntrySuggestion(
        entrySuggestionId: 'test string'
    );

    Saloon::assertSent(GetEntrySuggestionRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the deleteEntrySuggestion method in the EntrySuggestion resource', function () {
    Saloon::fake([
        DeleteEntrySuggestionRequest::class => MockResponse::fixture('entrySuggestion.deleteEntrySuggestion'),
    ]);

    $response = $this->timaticConnector->entrySuggestion()->deleteEntrySuggestion(
        entrySuggestionId: 'test string'
    );

    Saloon::assertSent(DeleteEntrySuggestionRequest::class);

    expect($response->status())->toBe(200);
});
