<?php

// Generated 2025-11-18 09:03:31

use Saloon\Http\Faking\MockResponse;
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

    $response = $this->timaticConnector->entrySuggestion()->getEntrySuggestions(
        filterdate: 'test string',
        filterdateeq: 'test string',
        filterdatenq: 'test string',
        filterdategt: 'test string',
        filterdatelt: 'test string',
        filterdategte: 'test string',
        filterdatelte: 'test string',
        filterdatecontains: 'test string'
    );

    Saloon::assertSent(GetEntrySuggestionsRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the getEntrySuggestion method in the EntrySuggestion resource', function () {
    Saloon::fake([
        GetEntrySuggestionRequest::class => MockResponse::fixture('entrySuggestion.getEntrySuggestion'),
    ]);

    $response = $this->timaticConnector->entrySuggestion()->getEntrySuggestion(
        entrySuggestion: 'test string'
    );

    Saloon::assertSent(GetEntrySuggestionRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the deleteEntrySuggestion method in the EntrySuggestion resource', function () {
    Saloon::fake([
        DeleteEntrySuggestionRequest::class => MockResponse::fixture('entrySuggestion.deleteEntrySuggestion'),
    ]);

    $response = $this->timaticConnector->entrySuggestion()->deleteEntrySuggestion(
        entrySuggestion: 'test string'
    );

    Saloon::assertSent(DeleteEntrySuggestionRequest::class);

    expect($response->status())->toBe(200);
});
