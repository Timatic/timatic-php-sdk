<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\BudgetType\GetBudgetTypesRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the getBudgetTypes method in the BudgetType resource', function () {
    Saloon::fake([
        GetBudgetTypesRequest::class => MockResponse::make([
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

    $request = (new GetBudgetTypesRequest);

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetBudgetTypesRequest::class);

    expect($response->status())->toBe(200);
});
