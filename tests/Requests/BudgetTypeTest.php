<?php

// auto-generated

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Requests\BudgetType\GetBudgetTypesRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\TimaticConnector;
});

it('calls the getBudgetTypes method in the BudgetType resource', function () {
    Saloon::fake([
        GetBudgetTypesRequest::class => MockResponse::make([
            'data' => [
                0 => [
                    'type' => 'budgetTypes',
                    'id' => 'mock-id-1',
                    'attributes' => [
                        'title' => 'Mock value',
                        'isArchived' => true,
                        'hasChangeTicket' => true,
                        'renewalFrequencies' => 'Mock value',
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
                        'renewalFrequencies' => 'Mock value',
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

    $request = (new GetBudgetTypesRequest);

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetBudgetTypesRequest::class);

    expect($response->status())->toBe(200);

    $dtoCollection = $response->dto();

    expect($dtoCollection->first())
        ->title->toBe('Mock value')
        ->isArchived->toBe(true)
        ->hasChangeTicket->toBe(true)
        ->renewalFrequencies->toBe('Mock value')
        ->hasSupervisor->toBe(true)
        ->hasContractId->toBe(true)
        ->hasTotalPrice->toBe(true)
        ->ticketIsRequired->toBe(true)
        ->defaultTitle->toBe('Mock value');
});
