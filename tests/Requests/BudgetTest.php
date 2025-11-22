<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\Budget\DeleteBudgetRequest;
use Timatic\SDK\Requests\Budget\GetBudgetRequest;
use Timatic\SDK\Requests\Budget\GetBudgetsRequest;
use Timatic\SDK\Requests\Budget\PatchBudgetRequest;
use Timatic\SDK\Requests\Budget\PostBudgetsRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the getBudgets method in the Budget resource', function () {
    Saloon::fake([
        GetBudgetsRequest::class => MockResponse::make([
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

    $request = (new GetBudgetsRequest(include: 'test string'))
        ->filter('customerId', 'test-id-123')
        ->filter('budgetTypeId', 'test-id-123')
        ->filter('isArchived', false);

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetBudgetsRequest::class);

    // Verify filter query parameters are present
    Saloon::assertSent(function (Request $request) {
        $query = $request->query()->all();

        expect($query)->toHaveKey('filter[customerId]', 'test-id-123');
        expect($query)->toHaveKey('filter[budgetTypeId]', 'test-id-123');
        expect($query)->toHaveKey('filter[isArchived]', false);

        return true;
    });

    expect($response->status())->toBe(200);
});

it('calls the postBudgets method in the Budget resource', function () {
    $mockClient = Saloon::fake([
        PostBudgetsRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = new \Timatic\SDK\Dto\Budget;
    $dto->budgetTypeId = 'test-id-123';
    $dto->customerId = 'test-id-123';
    $dto->showToCustomer = false;
    $dto->changeId = 'test-id-123';
    // todo: add every other DTO field

    $this->timaticConnector->budget()->postBudgets($dto);
    Saloon::assertSent(PostBudgetsRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            // POST calls dont have an ID field
            ->data->type->toBe('budget')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->budgetTypeId->toBe('test-id-123')
            ->customerId->toBe('test-id-123')
            ->showToCustomer->toBe(false)
            ->changeId->toBe('test-id-123')
            );

        return true;
    });
});

it('calls the getBudget method in the Budget resource', function () {
    Saloon::fake([
        GetBudgetRequest::class => MockResponse::make([
            'data' => [
                'type' => 'resources',
                'id' => 'mock-id-123',
                'attributes' => [
                    'data' => 'Mock value',
                ],
            ],
        ], 200),
    ]);

    $response = $this->timaticConnector->budget()->getBudget(
        budgetId: 'test string'
    );

    Saloon::assertSent(GetBudgetRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the deleteBudget method in the Budget resource', function () {
    Saloon::fake([
        DeleteBudgetRequest::class => MockResponse::make([], 200),
    ]);

    $response = $this->timaticConnector->budget()->deleteBudget(
        budgetId: 'test string'
    );

    Saloon::assertSent(DeleteBudgetRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the patchBudget method in the Budget resource', function () {
    $mockClient = Saloon::fake([
        PatchBudgetRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = new \Timatic\SDK\Dto\Budget;
    $dto->budgetTypeId = 'test-id-123';
    $dto->customerId = 'test-id-123';
    $dto->showToCustomer = false;
    $dto->changeId = 'test-id-123';
    // todo: add every other DTO field

    $this->timaticConnector->budget()->patchBudget(budgetId: 'test string', $dto);
    Saloon::assertSent(PatchBudgetRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('budget')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->budgetTypeId->toBe('test-id-123')
            ->customerId->toBe('test-id-123')
            ->showToCustomer->toBe(false)
            ->changeId->toBe('test-id-123')
            );

        return true;
    });
});
