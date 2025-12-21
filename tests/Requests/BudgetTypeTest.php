<?php

// auto-generated

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Requests\BudgetType\BudgetTypesCollectionRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\TimaticConnector;
});

it('calls the budgetTypesCollection method in the BudgetType resource', function () {
    Saloon::fake([
        BudgetTypesCollectionRequest::class => MockResponse::make([
            'data' => [
                0 => [
                    'type' => 'budgetTypes',
                    'id' => 'mock-id-1',
                    'attributes' => [
                        'title' => 'Mock value',
                        'isArchived' => true,
                        'hasChangeTicket' => true,
                        'renewalFrequencies' => [],
                        'hasSupervisor' => true,
                        'hasContractId' => true,
                        'hasTotalPrice' => true,
                        'ticketIsRequired' => true,
                        'defaultTitle' => 'Mock value',
                    ],
                ],
                1 => [
                    'type' => 'budgetTypes',
                    'id' => 'mock-id-2',
                    'attributes' => [
                        'title' => 'Mock value',
                        'isArchived' => true,
                        'hasChangeTicket' => true,
                        'renewalFrequencies' => [],
                        'hasSupervisor' => true,
                        'hasContractId' => true,
                        'hasTotalPrice' => true,
                        'ticketIsRequired' => true,
                        'defaultTitle' => 'Mock value',
                    ],
                ],
            ],
        ], 200),
    ]);

    $request = (new BudgetTypesCollectionRequest);

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(function (BudgetTypesCollectionRequest $request) {
        $query = $request->query()->all();

        return true;
    });

    expect($response->status())->toBe(200);

    $dtoCollection = $response->dto();

    expect($dtoCollection->first())
        ->title->toBe('Mock value')
        ->isArchived->toBe(true)
        ->hasChangeTicket->toBe(true)
        ->hasSupervisor->toBe(true)
        ->hasContractId->toBe(true)
        ->hasTotalPrice->toBe(true)
        ->ticketIsRequired->toBe(true)
        ->defaultTitle->toBe('Mock value');
});
