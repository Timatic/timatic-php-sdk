<?php

// auto-generated

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Requests\SuggestionIntegration\SuggestionIntegrationsCollectionRequest;
use Timatic\TimaticConnector;

beforeEach(function () {
    $this->timaticConnector = new TimaticConnector;
});

it('calls the suggestionIntegrationsCollection method in the SuggestionIntegration resource', function () {
    Saloon::fake([
        SuggestionIntegrationsCollectionRequest::class => MockResponse::make([
            'data' => [
                0 => [
                    'type' => 'suggestionIntegrations',
                    'id' => 'mock-id-1',
                    'attributes' => [
                        'label' => 'String value',
                        'iconUrl' => 'String value',
                        'instructions' => 'String value',
                        'isCompanyManaged' => true,
                        'isActive' => true,
                        'connectUrl' => 'String value',
                        'connectLabel' => 'String value',
                    ],
                ],
                1 => [
                    'type' => 'suggestionIntegrations',
                    'id' => 'mock-id-2',
                    'attributes' => [
                        'label' => 'String value',
                        'iconUrl' => 'String value',
                        'instructions' => 'String value',
                        'isCompanyManaged' => true,
                        'isActive' => true,
                        'connectUrl' => 'String value',
                        'connectLabel' => 'String value',
                    ],
                ],
            ],
        ], 200),
    ]);

    $request = (new SuggestionIntegrationsCollectionRequest);

    $dtoCollection = $this->timaticConnector->paginate($request)->dtoCollection();

    Saloon::assertSent(function (SuggestionIntegrationsCollectionRequest $request) {
        $query = $request->query()->all();

        return true;
    });

    expect($dtoCollection)->toHaveCount(2);

    expect($dtoCollection->first())
        ->label->toBe('String value')
        ->iconUrl->toBe('String value')
        ->instructions->toBe('String value')
        ->isCompanyManaged->toBe(true)
        ->isActive->toBe(true)
        ->connectUrl->toBe('String value')
        ->connectLabel->toBe('String value');
});
