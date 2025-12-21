<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Dto\Entry;
use Timatic\Requests\Entry\EntriesCollectionRequest;
use Timatic\TimaticConnector;

beforeEach(function () {
    $this->timaticConnector = new TimaticConnector;
});

it('returns DTOs instead of raw JSON:API fields when paginating', function () {
    // Mock the first page response with pagination links
    Saloon::fake([
        EntriesCollectionRequest::class => MockResponse::make([
            'data' => [
                [
                    'type' => 'entries',
                    'id' => 'entry-1',
                    'attributes' => [
                        'ticketId' => 'ticket-123',
                        'ticketNumber' => 'TICKET-001',
                        'ticketTitle' => 'First Entry',
                        'description' => 'First entry description',
                        'minutesSpent' => 60,
                        'startedAt' => '2025-12-15T10:00:00.000Z',
                        'endedAt' => '2025-12-15T11:00:00.000Z',
                    ],
                ],
                [
                    'type' => 'entries',
                    'id' => 'entry-2',
                    'attributes' => [
                        'ticketId' => 'ticket-456',
                        'ticketNumber' => 'TICKET-002',
                        'ticketTitle' => 'Second Entry',
                        'description' => 'Second entry description',
                        'minutesSpent' => 120,
                        'startedAt' => '2025-12-15T12:00:00.000Z',
                        'endedAt' => '2025-12-15T14:00:00.000Z',
                    ],
                ],
            ],
            'links' => [
                'next' => null,
            ],
        ], 200),
    ]);

    $request = new EntriesCollectionRequest;
    $paginator = $this->timaticConnector->paginate($request);

    // Get items from first page (convert Generator to array)
    $items = $paginator->dtoCollection();

    expect($items)->toHaveCount(2);

    // Verify first item is a proper Entry DTO with hydrated properties
    expect($items->first())
        ->toBeInstanceOf(Entry::class)
        ->ticketId->toBe('ticket-123')
        ->ticketNumber->toBe('TICKET-001')
        ->ticketTitle->toBe('First Entry')
        ->description->toBe('First entry description')
        ->minutesSpent->toBe(60);

    // Verify second item is also a proper Entry DTO
    expect($items[1])
        ->toBeInstanceOf(Entry::class)
        ->ticketId->toBe('ticket-456')
        ->ticketNumber->toBe('TICKET-002')
        ->ticketTitle->toBe('Second Entry')
        ->description->toBe('Second entry description')
        ->minutesSpent->toBe(120);
});

it('correctly follows pagination using links.next URL', function () {
    // Mock multiple pages with proper pagination links using sequence
    Saloon::fake([

        // First page
        MockResponse::make([
            'data' => [
                [
                    'type' => 'entries',
                    'id' => 'entry-1',
                    'attributes' => [
                        'ticketNumber' => 'PAGE-1-ITEM-1',
                        'minutesSpent' => 10,
                    ],
                ],
                [
                    'type' => 'entries',
                    'id' => 'entry-2',
                    'attributes' => [
                        'ticketNumber' => 'PAGE-1-ITEM-2',
                        'minutesSpent' => 20,
                    ],
                ],
            ],
            'links' => [
                'next' => 'https://api.example.com/entries?page[number]=2',
            ],
        ], 200),
        // Last page (last page, no next link)
        MockResponse::make([
            'data' => [
                [
                    'type' => 'entries',
                    'id' => 'entry-3',
                    'attributes' => [
                        'ticketNumber' => 'PAGE-2-ITEM-1',
                        'minutesSpent' => 50,
                    ],
                ],
            ],
            'links' => [
                'next' => null,
            ],
        ], 200),

    ]);

    $request = new EntriesCollectionRequest;
    $paginator = $this->timaticConnector->paginate($request);

    // Collect all items across all pages using items() method
    $allItems = $paginator->dtoCollection();

    // Verify we got all items from all 3 pages
    expect($allItems)->toHaveCount(3);

    // Verify items from each page
    expect($allItems[0]->ticketNumber)->toBe('PAGE-1-ITEM-1');
    expect($allItems[1]->ticketNumber)->toBe('PAGE-1-ITEM-2');
    expect($allItems[2]->ticketNumber)->toBe('PAGE-2-ITEM-1');
});

it('applies pagination query parameters correctly', function () {
    Saloon::fake([
        EntriesCollectionRequest::class => MockResponse::make([
            'data' => [],
            'links' => ['next' => null],
        ], 200),
    ]);

    $paginator = $this->timaticConnector
        ->paginate(new EntriesCollectionRequest)
        ->setPerPageLimit(123);

    $paginator->dtoCollection();

    // Verify the request had the correct query parameters
    Saloon::assertSent(function (EntriesCollectionRequest $request) {
        $query = $request->query()->all();

        expect($query)->toHaveKey('page[number]', 1);
        expect($query)->toHaveKey('page[size]', 123);

        return true;
    });
});
