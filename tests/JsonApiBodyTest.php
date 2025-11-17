<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Timatic\SDK\Dto\Budget;
use Timatic\SDK\Requests\Budget\PostBudgets;

it('sends valid JSON:API body when creating a budget with Model', function () {
    $mockClient = new MockClient([
        PostBudgets::class => MockResponse::make(status: 201),
    ]);

    // Create a Budget model with some data
    $budget = new Budget([
        'title' => 'Q1 2024 Budget',
        'description' => 'First quarter budget',
        'totalPrice' => '10000',
    ]);

    // Send the request
    $response = $this->timatic
        ->withMockClient($mockClient)
        ->send(new PostBudgets($budget));

    // Assert the request was sent
    $mockClient->assertSent(PostBudgets::class);

    // Validate JSON:API structure
    $mockClient->assertSent(function (Request $request) {
        $body = $request->body()->all();

        // Check for JSON:API 'data' wrapper
        if (! isset($body['data'])) {
            return false;
        }

        $data = $body['data'];

        // Validate required JSON:API fields
        if (! isset($data['type'])) {
            return false;
        }

        if (! isset($data['attributes'])) {
            return false;
        }

        // Validate that our budget data is in attributes
        if ($data['attributes']['title'] !== 'Q1 2024 Budget') {
            return false;
        }

        if ($data['attributes']['description'] !== 'First quarter budget') {
            return false;
        }

        return true;
    });

    expect($response->status())->toBe(201);
});

it('model has toJsonApi method that returns correct structure', function () {
    $budget = new Budget([
        'title' => 'Test Budget',
        'totalPrice' => '5000',
    ]);

    $jsonApi = $budget->toJsonApi();

    expect($jsonApi)->toHaveKey('data');
    expect($jsonApi['data'])->toHaveKey('type');
    expect($jsonApi['data'])->toHaveKey('attributes');
    expect($jsonApi['data']['type'])->toBe('budgets'); // Pluralized camelCase
    expect($jsonApi['data']['attributes'])->toBeArray();
    expect($jsonApi['data']['attributes'])->toHaveKey('title');
    expect($jsonApi['data']['attributes']['title'])->toBe('Test Budget');
});
