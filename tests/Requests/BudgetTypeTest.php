<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\BudgetType\GetBudgetTypesRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the getBudgetTypes method in the BudgetType resource', function () {
    Saloon::fake([
        GetBudgetTypesRequest::class => MockResponse::fixture('budgetType.getBudgetTypes'),
    ]);

    $response = $this->timaticConnector->budgetType()->getBudgetTypes(

    );

    Saloon::assertSent(GetBudgetTypesRequest::class);

    expect($response->status())->toBe(200);
});
