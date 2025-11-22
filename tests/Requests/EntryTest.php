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
        ->filter('startedAt', '2025-01-01T10:00:00Z');

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetEntriesRequest::class);

    // Verify filter query parameters are present
    Saloon::assertSent(function (Request $request) {
        $query = $request->query()->all();

        expect($query)->toHaveKey('filter[userId]', 'test-id-123');
        expect($query)->toHaveKey('filter[budgetId]', 'test-id-123');
        expect($query)->toHaveKey('filter[startedAt]', '2025-01-01T10:00:00Z');

        return true;
    });

    expect($response->status())->toBe(200);
});

it('calls the postEntries method in the Entry resource', function () {
    $mockClient = Saloon::fake([
        PostEntriesRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = new \Timatic\SDK\Dto\Entry;
    $dto->ticketId = 'mock-id-123';
    $dto->ticketNumber = 'test value';
    $dto->ticketTitle = 'test value';
    $dto->ticketType = 'test value';
    // todo: add every other DTO field

    $this->timaticConnector->entry()->postEntries($dto);
    Saloon::assertSent(PostEntriesRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            // POST calls dont have an ID field
            ->data->type->toBe('entry')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->ticketId->toBe('mock-id-123')
            ->ticketNumber->toBe('test value')
            ->ticketTitle->toBe('test value')
            ->ticketType->toBe('test value')
            );

        return true;
    });
});

it('calls the getEntry method in the Entry resource', function () {
    Saloon::fake([
        GetEntryRequest::class => MockResponse::make([
            'data' => [
                'type' => 'resources',
                'id' => 'mock-id-123',
                'attributes' => [
                    'name' => 'Mock value',
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
    $mockClient = Saloon::fake([
        PatchEntryRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = new \Timatic\SDK\Dto\Entry;
    $dto->ticketId = 'mock-id-123';
    $dto->ticketNumber = 'test value';
    $dto->ticketTitle = 'test value';
    $dto->ticketType = 'test value';
    // todo: add every other DTO field

    $this->timaticConnector->entry()->patchEntry(entryId: 'test string', $dto);
    Saloon::assertSent(PatchEntryRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('entry')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->ticketId->toBe('mock-id-123')
            ->ticketNumber->toBe('test value')
            ->ticketTitle->toBe('test value')
            ->ticketType->toBe('test value')
            );

        return true;
    });
});
