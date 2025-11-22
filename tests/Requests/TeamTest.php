<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
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
    $mockClient = Saloon::fake([
        PostTeamsRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = new \Timatic\SDK\Dto\Team;
    $dto->externalId = 'mock-id-123';
    $dto->name = 'test value';
    // todo: add every other DTO field

    $this->timaticConnector->team()->postTeams($dto);
    Saloon::assertSent(PostTeamsRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            // POST calls dont have an ID field
            ->data->type->toBe('team')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->externalId->toBe('mock-id-123')
            ->name->toBe('test value')
            );

        return true;
    });
});

it('calls the getTeam method in the Team resource', function () {
    Saloon::fake([
        GetTeamRequest::class => MockResponse::make([
            'data' => [
                'type' => 'resources',
                'id' => 'mock-id-123',
                'attributes' => [
                    'name' => 'Mock value',
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
    $mockClient = Saloon::fake([
        PatchTeamRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = new \Timatic\SDK\Dto\Team;
    $dto->externalId = 'mock-id-123';
    $dto->name = 'test value';
    // todo: add every other DTO field

    $this->timaticConnector->team()->patchTeam(teamId: 'test string', $dto);
    Saloon::assertSent(PatchTeamRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('team')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->externalId->toBe('mock-id-123')
            ->name->toBe('test value')
            );

        return true;
    });
});
