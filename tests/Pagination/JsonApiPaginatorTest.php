<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Dto\Activity;
use Timatic\TimaticConnector;

beforeEach(function () {
    $this->connector = new TimaticConnector;
});

it('returns DTOs instead of raw JSON:API fields when paginating', function () {
    // Create a simple request for testing pagination
    $request = new class extends Request
    {
        protected ?string $method = 'GET';

        public function resolveEndpoint(): string
        {
            return '/activitys';
        }
    };

    Saloon::fake([
        MockResponse::make([
            'data' => [
                [
                    'type' => 'activitys',
                    'id' => 'item-1',
                    'attributes' => [
                        'sourceId' => 'First Item',
                    ],
                ],
                [
                    'type' => 'activitys',
                    'id' => 'item-2',
                    'attributes' => [
                        'sourceId' => 'Second Item',
                    ],
                ],
            ],
            'links' => [
                'next' => null,
            ],
        ], 200),
    ]);

    $paginator = $this->connector->paginate($request);
    $items = $paginator->dtoCollection();

    expect($items)->toHaveCount(2);

    expect($items->first())
        ->toBeInstanceOf(Activity::class)
        ->sourceId->toBe('First Item');

    expect($items[1])
        ->toBeInstanceOf(Activity::class)
        ->sourceId->toBe('Second Item');
});

it('correctly follows pagination using links.next URL', function () {
    $request = new class extends Request
    {
        protected ?string $method = 'GET';

        public function resolveEndpoint(): string
        {
            return '/activitys';
        }
    };

    Saloon::fake([
        // First page
        MockResponse::make([
            'data' => [
                [
                    'type' => 'activitys',
                    'id' => 'item-1',
                    'attributes' => [
                        'sourceId' => 'PAGE-1-ITEM-1',
                    ],
                ],
            ],
            'links' => [
                'next' => 'https://api.example.com/activitys?page[number]=2',
            ],
        ], 200),
        // Second page (last)
        MockResponse::make([
            'data' => [
                [
                    'type' => 'activitys',
                    'id' => 'item-2',
                    'attributes' => [
                        'sourceId' => 'PAGE-2-ITEM-1',
                    ],
                ],
            ],
            'links' => [
                'next' => null,
            ],
        ], 200),
    ]);

    $paginator = $this->connector->paginate($request);
    $allItems = $paginator->dtoCollection();

    expect($allItems)->toHaveCount(2);
    expect($allItems[0]->sourceId)->toBe('PAGE-1-ITEM-1');
    expect($allItems[1]->sourceId)->toBe('PAGE-2-ITEM-1');
});

it('applies pagination query parameters correctly', function () {
    $request = new class extends Request
    {
        protected ?string $method = 'GET';

        public function resolveEndpoint(): string
        {
            return '/activitys';
        }
    };

    Saloon::fake([
        MockResponse::make([
            'data' => [],
            'links' => ['next' => null],
        ], 200),
    ]);

    $paginator = $this->connector
        ->paginate($request)
        ->setPerPageLimit(25);

    $paginator->dtoCollection();

    Saloon::assertSent(function (Request $sentRequest) {
        $query = $sentRequest->query()->all();

        expect($query)->toHaveKey('page[number]', 1);
        expect($query)->toHaveKey('page[size]', 25);

        return true;
    });
});
