<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\Entry\DeleteEntryRequest;
use Timatic\SDK\Requests\Entry\GetEntriesRequest;
use Timatic\SDK\Requests\Entry\GetEntryRequest;
use Timatic\SDK\Requests\Entry\PatchEntryRequest;
use Timatic\SDK\Requests\Entry\PostEntriesRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the getEntries method in the Entry resource', function () {
    Saloon::fake([
        GetEntriesRequest::class => MockResponse::make([
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

    $request = (new GetEntriesRequest(include: 'test string'))
        ->filter('userId', 'test-id-123')
        ->filter('budgetId', 'test-id-123')
        ->filter('startedAt', '2025-01-01');

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetEntriesRequest::class);

    // Verify filter query parameters are present
    Saloon::assertSent(function (Request $request) {
        $query = $request->query()->all();

        expect($query)->toHaveKey('filter[userId]', 'test-id-123');
        expect($query)->toHaveKey('filter[budgetId]', 'test-id-123');
        expect($query)->toHaveKey('filter[startedAt]', '2025-01-01');

        return true;
    });

    expect($response->status())->toBe(200);
});

it('calls the postEntries method in the Entry resource', function () {
    Saloon::fake([
        PostEntriesRequest::class => MockResponse::make([], 200),
    ]);

    $response = $this->timaticConnector->entry()->postEntries(

    );

    Saloon::assertSent(PostEntriesRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the getEntry method in the Entry resource', function () {
    Saloon::fake([
        GetEntryRequest::class => MockResponse::make([
            'data' => [
                'type' => 'resources',
                'id' => 'mock-id-123',
                'attributes' => [
                    'data' => 'Mock value',
                ],
            ],
        ], 200),
    ]);

    $response = $this->timaticConnector->entry()->getEntry(
        entryId: 'test string'
    );

    Saloon::assertSent(GetEntryRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the deleteEntry method in the Entry resource', function () {
    Saloon::fake([
        DeleteEntryRequest::class => MockResponse::make([], 200),
    ]);

    $response = $this->timaticConnector->entry()->deleteEntry(
        entryId: 'test string'
    );

    Saloon::assertSent(DeleteEntryRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the patchEntry method in the Entry resource', function () {
    Saloon::fake([
        PatchEntryRequest::class => MockResponse::make([], 200),
    ]);

    $response = $this->timaticConnector->entry()->patchEntry(
        entryId: 'test string'
    );

    Saloon::assertSent(PatchEntryRequest::class);

    expect($response->status())->toBe(200);
});
