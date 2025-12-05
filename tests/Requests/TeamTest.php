<?php

// auto-generated

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Requests\Team\DeleteTeamRequest;
use Timatic\Requests\Team\GetTeamRequest;
use Timatic\Requests\Team\GetTeamsRequest;
use Timatic\Requests\Team\PatchTeamRequest;
use Timatic\Requests\Team\PostTeamsRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\TimaticConnector;
});

it('calls the getTeams method in the Team resource', function () {
    Saloon::fake([
        GetTeamsRequest::class => MockResponse::make([
            'data' => [
                0 => [
                    'type' => 'teams',
                    'id' => 'mock-id-1',
                    'attributes' => [
                        'externalId' => 'mock-id-123',
                        'name' => 'Mock value',
                    ],
                ],
                1 => [
                    'type' => 'teams',
                    'id' => 'mock-id-2',
                    'attributes' => [
                        'externalId' => 'mock-id-123',
                        'name' => 'Mock value',
                    ],
                ],
            ],
        ], 200),
    ]);

    $request = (new GetTeamsRequest);

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetTeamsRequest::class);

    expect($response->status())->toBe(200);

    $dtoCollection = $response->dto();

    expect($dtoCollection->first())
        ->externalId->toBe('mock-id-123')
        ->name->toBe('Mock value');
});

it('calls the postTeams method in the Team resource', function () {
    $mockClient = Saloon::fake([
        PostTeamsRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = \Timatic\Dto\Team::factory()->state([
        'externalId' => 'external_id-123',
        'name' => 'test name',
    ])->make();

    $request = new PostTeamsRequest($dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(PostTeamsRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('teams')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->externalId->toBe('external_id-123')
            ->name->toBe('test name')
            );

        return true;
    });
});

it('calls the getTeam method in the Team resource', function () {
    Saloon::fake([
        GetTeamRequest::class => MockResponse::make([
            'data' => [
                'type' => 'teams',
                'id' => 'mock-id-123',
                'attributes' => [
                    'externalId' => 'mock-id-123',
                    'name' => 'Mock value',
                ],
            ],
        ], 200),
    ]);

    $request = new GetTeamRequest(
        teamId: 'test string'
    );
    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetTeamRequest::class);

    expect($response->status())->toBe(200);

    $dto = $response->dto();

    expect($dto)
        ->externalId->toBe('mock-id-123')
        ->name->toBe('Mock value');
});

it('calls the deleteTeam method in the Team resource', function () {
    Saloon::fake([
        DeleteTeamRequest::class => MockResponse::make([], 200),
    ]);

    $request = new DeleteTeamRequest(
        teamId: 'test string'
    );
    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(DeleteTeamRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the patchTeam method in the Team resource', function () {
    $mockClient = Saloon::fake([
        PatchTeamRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = \Timatic\Dto\Team::factory()->state([
        'externalId' => 'external_id-123',
        'name' => 'test name',
    ])->make();

    $request = new PatchTeamRequest(teamId: 'test string', data: $dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(PatchTeamRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('teams')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->externalId->toBe('external_id-123')
            ->name->toBe('test name')
            );

        return true;
    });
});
