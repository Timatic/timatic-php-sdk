<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\DataTransferObjects\Budget;
use Timatic\Requests\Budget\BudgetsCollectionRequest;
use Timatic\TimaticConnector;

beforeEach(function () {
    $this->connector = new TimaticConnector;
});

it('returns DTOs instead of raw JSON:API fields when paginating', function () {
    $request = new BudgetsCollectionRequest;

    Saloon::fake([
        MockResponse::make([
            'data' => [
                [
                    'type' => 'budgets',
                    'id' => 'item-1',
                    'attributes' => [
                        'title' => 'First Item',
                    ],
                ],
                [
                    'type' => 'budgets',
                    'id' => 'item-2',
                    'attributes' => [
                        'title' => 'Second Item',
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
        ->toBeInstanceOf(Budget::class)
        ->title->toBe('First Item');

    expect($items[1])
        ->toBeInstanceOf(Budget::class)
        ->title->toBe('Second Item');
});

it('correctly follows pagination using links.next URL', function () {
    $request = new BudgetsCollectionRequest;

    Saloon::fake([
        // First page
        MockResponse::make([
            'data' => [
                [
                    'type' => 'budgets',
                    'id' => 'item-1',
                    'attributes' => [
                        'title' => 'PAGE-1-ITEM-1',
                    ],
                ],
            ],
            'links' => [
                'next' => 'https://api.example.com/budgets?page[number]=2',
            ],
        ], 200),
        // Second page (last)
        MockResponse::make([
            'data' => [
                [
                    'type' => 'budgets',
                    'id' => 'item-2',
                    'attributes' => [
                        'title' => 'PAGE-2-ITEM-1',
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
    expect($allItems[0]->title)->toBe('PAGE-1-ITEM-1');
    expect($allItems[1]->title)->toBe('PAGE-2-ITEM-1');
});

it('applies pagination query parameters correctly', function () {
    $request = new BudgetsCollectionRequest;

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
