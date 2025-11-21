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
        GetBudgetsRequest::class => MockResponse::fixture('budget.getBudgets'),
    ]);

    $request = (new GetBudgetsRequest(include: 'test string'))
        ->filter('customerId', 'test-id-123')
        ->filter('budgetTypeId', 'test-id-123')
        ->filter('isArchived', true);

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetBudgetsRequest::class);

    // Verify filter query parameters are present
    Saloon::assertSent(function (Request $request) {
        $query = $request->query()->all();

        expect($query)->toHaveKey('filter[customerId]', 'test-id-123');
        expect($query)->toHaveKey('filter[budgetTypeId]', 'test-id-123');
        expect($query)->toHaveKey('filter[isArchived]', true);

        return true;
    });

    expect($response->status())->toBe(200);
});

it('calls the postBudgets method in the Budget resource', function () {
    Saloon::fake([
        PostBudgetsRequest::class => MockResponse::fixture('budget.postBudgets'),
    ]);

    $response = $this->timaticConnector->budget()->postBudgets(

    );

    Saloon::assertSent(PostBudgetsRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the getBudget method in the Budget resource', function () {
    Saloon::fake([
        GetBudgetRequest::class => MockResponse::fixture('budget.getBudget'),
    ]);

    $response = $this->timaticConnector->budget()->getBudget(
        budgetId: 'test string'
    );

    Saloon::assertSent(GetBudgetRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the deleteBudget method in the Budget resource', function () {
    Saloon::fake([
        DeleteBudgetRequest::class => MockResponse::fixture('budget.deleteBudget'),
    ]);

    $response = $this->timaticConnector->budget()->deleteBudget(
        budgetId: 'test string'
    );

    Saloon::assertSent(DeleteBudgetRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the patchBudget method in the Budget resource', function () {
    Saloon::fake([
        PatchBudgetRequest::class => MockResponse::fixture('budget.patchBudget'),
    ]);

    $response = $this->timaticConnector->budget()->patchBudget(
        budgetId: 'test string'
    );

    Saloon::assertSent(PatchBudgetRequest::class);

    expect($response->status())->toBe(200);
});
