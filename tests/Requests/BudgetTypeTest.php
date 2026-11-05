<?php

// auto-generated

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Requests\BudgetType\BudgetTypesCollectionRequest;
use Timatic\TimaticConnector;

beforeEach(function () {
    $this->timaticConnector = new TimaticConnector;
});

it('calls the budgetTypesCollection method in the BudgetType resource', function () {
    Saloon::fake([
        BudgetTypesCollectionRequest::class => MockResponse::make([
            'data' => [
                0 => [
                    'type' => 'budgetTypes',
                    'id' => 'mock-id-1',
                    'attributes' => [
                        'title' => 'String value',
                        'isArchived' => true,
                        'hasChangeTicket' => true,
                        'renewalFrequencies' => [],
                        'hasSupervisor' => true,
                        'hasContractId' => true,
                        'hasTotalPrice' => true,
                        'ticketIsRequired' => true,
                        'defaultTitle' => 'String value',
                    ],
                ],
                1 => [
                    'type' => 'budgetTypes',
                    'id' => 'mock-id-2',
                    'attributes' => [
                        'title' => 'String value',
                        'isArchived' => true,
                        'hasChangeTicket' => true,
                        'renewalFrequencies' => [],
                        'hasSupervisor' => true,
                        'hasContractId' => true,
                        'hasTotalPrice' => true,
                        'ticketIsRequired' => true,
                        'defaultTitle' => 'String value',
                    ],
                ],
            ],
        ], 200),
    ]);

    $request = (new BudgetTypesCollectionRequest);

    $dtoCollection = $this->timaticConnector->paginate($request)->dtoCollection();

    Saloon::assertSent(function (BudgetTypesCollectionRequest $request) {
        $query = $request->query()->all();

        return true;
    });

    expect($dtoCollection)->toHaveCount(2);

    expect($dtoCollection->first())
        ->title->toBe('String value')
        ->isArchived->toBe(true)
        ->hasChangeTicket->toBe(true)
        ->hasSupervisor->toBe(true)
        ->hasContractId->toBe(true)
        ->hasTotalPrice->toBe(true)
        ->ticketIsRequired->toBe(true)
        ->defaultTitle->toBe('String value');
});
