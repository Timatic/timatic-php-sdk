<?php

// Generated 2025-11-17 21:22:04

use Saloon\Http\Faking\MockResponse;
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

    $response = $this->timaticConnector->budget()->getBudgets(
        filtercustomerId: 123,
        filtercustomerIdeq: 123,
        filtercustomerIdnq: 123,
        filtercustomerIdgt: 123,
        filtercustomerIdlt: 123,
        filtercustomerIdgte: 123,
        filtercustomerIdlte: 123,
        filtercustomerIdcontains: 123,
        filterbudgetTypeId: 'test string',
        filterbudgetTypeIdeq: 'test string',
        filterbudgetTypeIdnq: 'test string',
        filterbudgetTypeIdgt: 'test string',
        filterbudgetTypeIdlt: 'test string',
        filterbudgetTypeIdgte: 'test string',
        filterbudgetTypeIdlte: 'test string',
        filterbudgetTypeIdcontains: 'test string',
        filterisArchived: 'test string',
        filtercustomerExternalId: 'test string',
        filtershowToCustomer: 'test string',
        include: 'test string'
    );

    Saloon::assertSent(GetBudgetsRequest::class);

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
        budget: 'test string'
    );

    Saloon::assertSent(GetBudgetRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the deleteBudget method in the Budget resource', function () {
    Saloon::fake([
        DeleteBudgetRequest::class => MockResponse::fixture('budget.deleteBudget'),
    ]);

    $response = $this->timaticConnector->budget()->deleteBudget(
        budget: 'test string'
    );

    Saloon::assertSent(DeleteBudgetRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the patchBudget method in the Budget resource', function () {
    Saloon::fake([
        PatchBudgetRequest::class => MockResponse::fixture('budget.patchBudget'),
    ]);

    $response = $this->timaticConnector->budget()->patchBudget(
        budget: 'test string'
    );

    Saloon::assertSent(PatchBudgetRequest::class);

    expect($response->status())->toBe(200);
});
