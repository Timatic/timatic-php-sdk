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
        GetIncidentRequest::class => MockResponse::fixture('incident.getIncident'),
    ]);

    $response = $this->timaticConnector->incident()->getIncident(
        incidentId: 'test string'
    );

    Saloon::assertSent(GetIncidentRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the getIncidents method in the Incident resource', function () {
    Saloon::fake([
        GetIncidentsRequest::class => MockResponse::fixture('incident.getIncidents'),
    ]);

    $request = (new GetIncidentsRequest);

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetIncidentsRequest::class);

    expect($response->status())->toBe(200);
});
