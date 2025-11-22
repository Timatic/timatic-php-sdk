<?php

use Carbon\Carbon;
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
                        'budgetTypeId' => 'mock-id-123',
                        'customerId' => 'mock-id-123',
                        'showToCustomer' => true,
                        'changeId' => 'mock-id-123',
                        'contractId' => 'mock-id-123',
                        'title' => 'Mock value',
                        'description' => 'Mock value',
                        'totalPrice' => 'Mock value',
                        'startedAt' => '2025-11-22T10:40:04.065Z',
                        'endedAt' => '2025-11-22T10:40:04.065Z',
                        'initialMinutes' => 42,
                        'isArchived' => true,
                        'renewalFrequency' => 'Mock value',
                        'supervisorUserId' => 'mock-id-123',
                    ],
                ],
                1 => [
                    'type' => 'resources',
                    'id' => 'mock-id-2',
                    'attributes' => [
                        'budgetTypeId' => 'mock-id-123',
                        'customerId' => 'mock-id-123',
                        'showToCustomer' => true,
                        'changeId' => 'mock-id-123',
                        'contractId' => 'mock-id-123',
                        'title' => 'Mock value',
                        'description' => 'Mock value',
                        'totalPrice' => 'Mock value',
                        'startedAt' => '2025-11-22T10:40:04.065Z',
                        'endedAt' => '2025-11-22T10:40:04.065Z',
                        'initialMinutes' => 42,
                        'isArchived' => true,
                        'renewalFrequency' => 'Mock value',
                        'supervisorUserId' => 'mock-id-123',
                    ],
                ],
            ],
        ], 200),
    ]);

    $request = (new GetBudgetsRequest(include: 'test string'))
        ->filter('customerId', 'customer_id-123')
        ->filter('budgetTypeId', 'budget_type_id-123')
        ->filter('isArchived', true);

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetBudgetsRequest::class);

    // Verify filter query parameters are present
    Saloon::assertSent(function (Request $request) {
        $query = $request->query()->all();

        expect($query)->toHaveKey('filter[customerId]', 'customer_id-123');
        expect($query)->toHaveKey('filter[budgetTypeId]', 'budget_type_id-123');
        expect($query)->toHaveKey('filter[isArchived]', true);

        return true;
    });

    expect($response->status())->toBe(200);

    $dtoCollection = $response->dto();

    expect($dtoCollection->first())
        ->budgetTypeId->toBe('mock-id-123')
        ->customerId->toBe('mock-id-123')
        ->showToCustomer->toBe(true)
        ->changeId->toBe('mock-id-123')
        ->contractId->toBe('mock-id-123')
        ->title->toBe('Mock value')
        ->description->toBe('Mock value')
        ->totalPrice->toBe('Mock value')
        ->startedAt->toEqual(new Carbon('2025-11-22T10:40:04.065Z'))
        ->endedAt->toEqual(new Carbon('2025-11-22T10:40:04.065Z'))
        ->initialMinutes->toBe(42)
        ->isArchived->toBe(true)
        ->renewalFrequency->toBe('Mock value')
        ->supervisorUserId->toBe('mock-id-123');
});

it('calls the postBudgets method in the Budget resource', function () {
    $mockClient = Saloon::fake([
        PostBudgetsRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = new \Timatic\SDK\Dto\Budget;
    $dto->budgetTypeId = 'budget_type_id-123';
    $dto->customerId = 'customer_id-123';
    $dto->showToCustomer = true;
    $dto->changeId = 'change_id-123';
    // todo: add every other DTO field

    $this->timaticConnector->budget()->postBudgets($dto);
    Saloon::assertSent(PostBudgetsRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            // POST calls dont have an ID field
            ->data->type->toBe('budgets')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->budgetTypeId->toBe('budget_type_id-123')
            ->customerId->toBe('customer_id-123')
            ->showToCustomer->toBe(true)
            ->changeId->toBe('change_id-123')
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
                    'budgetTypeId' => 'mock-id-123',
                    'customerId' => 'mock-id-123',
                    'showToCustomer' => true,
                    'changeId' => 'mock-id-123',
                    'contractId' => 'mock-id-123',
                    'title' => 'Mock value',
                    'description' => 'Mock value',
                    'totalPrice' => 'Mock value',
                    'startedAt' => '2025-11-22T10:40:04.065Z',
                    'endedAt' => '2025-11-22T10:40:04.065Z',
                    'initialMinutes' => 42,
                    'isArchived' => true,
                    'renewalFrequency' => 'Mock value',
                    'supervisorUserId' => 'mock-id-123',
                ],
            ],
        ], 200),
    ]);

    $response = $this->timaticConnector->budget()->getBudget(
        budgetId: 'test string'
    );

    Saloon::assertSent(GetBudgetRequest::class);

    expect($response->status())->toBe(200);

    $dto = $response->dto();

    expect($dto)
        ->budgetTypeId->toBe('mock-id-123')
        ->customerId->toBe('mock-id-123')
        ->showToCustomer->toBe(true)
        ->changeId->toBe('mock-id-123')
        ->contractId->toBe('mock-id-123')
        ->title->toBe('Mock value')
        ->description->toBe('Mock value')
        ->totalPrice->toBe('Mock value')
        ->startedAt->toEqual(new Carbon('2025-11-22T10:40:04.065Z'))
        ->endedAt->toEqual(new Carbon('2025-11-22T10:40:04.065Z'))
        ->initialMinutes->toBe(42)
        ->isArchived->toBe(true)
        ->renewalFrequency->toBe('Mock value')
        ->supervisorUserId->toBe('mock-id-123');
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
    $dto->budgetTypeId = 'budget_type_id-123';
    $dto->customerId = 'customer_id-123';
    $dto->showToCustomer = true;
    $dto->changeId = 'change_id-123';
    // todo: add every other DTO field

    $this->timaticConnector->budget()->patchBudget(budgetId: 'test string', data: $dto);
    Saloon::assertSent(PatchBudgetRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('budgets')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->budgetTypeId->toBe('budget_type_id-123')
            ->customerId->toBe('customer_id-123')
            ->showToCustomer->toBe(true)
            ->changeId->toBe('change_id-123')
            );

        return true;
    });
});
