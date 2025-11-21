<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\Team\DeleteTeamRequest;
use Timatic\SDK\Requests\Team\GetTeamRequest;
use Timatic\SDK\Requests\Team\GetTeamsRequest;
use Timatic\SDK\Requests\Team\PatchTeamRequest;
use Timatic\SDK\Requests\Team\PostTeamsRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the getTeams method in the Team resource', function () {
    Saloon::fake([
        GetTeamsRequest::class => MockResponse::make([
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

    $request = (new GetTeamsRequest);

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetTeamsRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the postTeams method in the Team resource', function () {
    Saloon::fake([
        PostTeamsRequest::class => MockResponse::make([], 200),
    ]);

    $response = $this->timaticConnector->team()->postTeams(

    );

    Saloon::assertSent(PostTeamsRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the getTeam method in the Team resource', function () {
    Saloon::fake([
        GetTeamRequest::class => MockResponse::make([
            'data' => [
                'type' => 'resources',
                'id' => 'mock-id-123',
                'attributes' => [
                    'data' => 'Mock value',
                ],
            ],
        ], 200),
    ]);

    $response = $this->timaticConnector->team()->getTeam(
        teamId: 'test string'
    );

    Saloon::assertSent(GetTeamRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the deleteTeam method in the Team resource', function () {
    Saloon::fake([
        DeleteTeamRequest::class => MockResponse::make([], 200),
    ]);

    $response = $this->timaticConnector->team()->deleteTeam(
        teamId: 'test string'
    );

    Saloon::assertSent(DeleteTeamRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the patchTeam method in the Team resource', function () {
    Saloon::fake([
        PatchTeamRequest::class => MockResponse::make([], 200),
    ]);

    $response = $this->timaticConnector->team()->patchTeam(
        teamId: 'test string'
    );

    Saloon::assertSent(PatchTeamRequest::class);

    expect($response->status())->toBe(200);
});
