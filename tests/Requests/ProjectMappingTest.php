<?php

// auto-generated

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Requests\ProjectMapping\JiraProjectMappingsCollectionRequest;
use Timatic\TimaticConnector;

beforeEach(function () {
    $this->timaticConnector = new TimaticConnector;
});

it('calls the jiraProjectMappingsCollection method in the ProjectMapping resource', function () {
    Saloon::fake([
        JiraProjectMappingsCollectionRequest::class => MockResponse::make([
            'data' => [
                0 => [
                    'type' => 'projectMappings',
                    'id' => 'mock-id-1',
                    'attributes' => [
                        'projectKey' => 'String value',
                        'projectName' => 'String value',
                        'customerId' => 42,
                        'budgetId' => 42,
                        'isArchived' => true,
                    ],
                ],
                1 => [
                    'type' => 'projectMappings',
                    'id' => 'mock-id-2',
                    'attributes' => [
                        'projectKey' => 'String value',
                        'projectName' => 'String value',
                        'customerId' => 42,
                        'budgetId' => 42,
                        'isArchived' => true,
                    ],
                ],
            ],
        ], 200),
    ]);

    $request = (new JiraProjectMappingsCollectionRequest);

    $dtoCollection = $this->timaticConnector->paginate($request)->dtoCollection();

    Saloon::assertSent(function (JiraProjectMappingsCollectionRequest $request) {
        $query = $request->query()->all();

        return true;
    });

    expect($dtoCollection)->toHaveCount(2);

    expect($dtoCollection->first())
        ->projectKey->toBe('String value')
        ->projectName->toBe('String value')
        ->customerId->toBe(42)
        ->budgetId->toBe(42)
        ->isArchived->toBe(true);
});
