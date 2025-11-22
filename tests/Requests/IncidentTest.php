<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\Incident\GetIncidentRequest;
use Timatic\SDK\Requests\Incident\GetIncidentsRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the getIncident method in the Incident resource', function () {
    Saloon::fake([
        GetIncidentRequest::class => MockResponse::make([
            'data' => [
                'type' => 'resources',
                'id' => 'mock-id-123',
                'attributes' => [
                    'name' => 'Mock value',
                ],
            ],
        ], 200),
    ]);

    $response = $this->timaticConnector->incident()->getIncident(
        incidentId: 'test string'
    );

    Saloon::assertSent(GetIncidentRequest::class);

    expect($response->status())->toBe(200);

    $dto = $response->dto();

    expect($dto)
        ->name->toBe('Mock value');
});

it('calls the getIncidents method in the Incident resource', function () {
    Saloon::fake([
        GetIncidentsRequest::class => MockResponse::make([
            'data' => [
                0 => [
                    'type' => 'resources',
                    'id' => 'mock-id-1',
                    'attributes' => [
                        'name' => 'Mock value',
                    ],
                ],
                1 => [
                    'type' => 'resources',
                    'id' => 'mock-id-2',
                    'attributes' => [
                        'name' => 'Mock value',
                    ],
                ],
            ],
        ], 200),
    ]);

    $request = (new GetIncidentsRequest);

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetIncidentsRequest::class);

    expect($response->status())->toBe(200);

    $dtoCollection = $response->dto();

    expect($dtoCollection->first())
        ->name->toBe('Mock value');
});
