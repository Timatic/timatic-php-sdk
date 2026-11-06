<?php

use Timatic\DataTransferObjects\Budget;
use Timatic\Foundation\JsonApi\JsonApiSerializer;

test('it can create a budget using factory', function () {
    $budget = Budget::testFactory()
        ->state([
            'title' => 'Project Budget',
        ])
        ->make();

    expect($budget)
        ->toBeInstanceOf(Budget::class)
        ->title->toBe('Project Budget')
        ->totalPrice->toBeString()
        ->customerId->toBeString();
});

test('it can create multiple budgets using factory', function () {
    $budgets = Budget::testFactory()->count(3)->make();

    expect($budgets)->toHaveCount(3);
    $budgets->each(fn ($budget) => expect($budget)->toBeInstanceOf(Budget::class));
});

test('it can override attributes using state', function () {
    $budget = Budget::testFactory()->state([
        'title' => 'Custom Title',
        'totalPrice' => '1234.56',
    ])->make();

    expect($budget)
        ->title->toBe('Custom Title')
        ->totalPrice->toBe('1234.56');
});

test('it can chain state calls', function () {
    $budget = Budget::testFactory()
        ->state(['title' => 'First'])
        ->state(['totalPrice' => '100.00'])
        ->make();

    expect($budget)
        ->title->toBe('First')
        ->totalPrice->toBe('100.00');
});

test('it converts to json api format correctly', function () {
    $budget = Budget::testFactory()->state([
        'id' => 'test-123',
        'title' => 'Test Budget',
        'totalPrice' => '999.99',
    ])->make();

    $jsonApi = JsonApiSerializer::toJsonApi($budget);

    expect($jsonApi)
        ->toHaveKeys(['type', 'id', 'attributes'])
        ->type->toBe('budgets')
        ->id->toBe('test-123')
        ->attributes->toHaveKey('title', 'Test Budget')
        ->toHaveKey('totalPrice', '999.99');
});

test('it can generate multiple budgets with unique UUID IDs', function () {
    $budgets = Budget::testFactory()->withId()->count(3)->make();

    expect($budgets)->toHaveCount(3);

    $ids = $budgets->pluck('id');

    // All budgets should have IDs
    $budgets->each(fn ($budget) => expect($budget->id)->toBeString()->not->toBeEmpty());

    // All IDs should be unique
    expect($ids->unique())->toHaveCount(3);
});
