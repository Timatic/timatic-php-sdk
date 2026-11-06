<?php

// auto-generated

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\DataTransferObjects\NewTeam;
use Timatic\DataTransferObjects\UpdateTeam;
use Timatic\Requests\Team\TeamsCollectionRequest;
use Timatic\Requests\Team\TeamsDestroyRequest;
use Timatic\Requests\Team\TeamsShowRequest;
use Timatic\Requests\Team\TeamsStoreRequest;
use Timatic\Requests\Team\TeamsUpdateRequest;
use Timatic\TimaticConnector;

beforeEach(function () {
    $this->timaticConnector = new TimaticConnector;
});

it('calls the teamsCollection method in the Team resource', function () {
    Saloon::fake([
        TeamsCollectionRequest::class => MockResponse::make([
            'data' => [
                0 => [
                    'type' => 'teams',
                    'id' => 'mock-id-1',
                    'attributes' => [
                        'externalId' => 'mock-id-123',
                        'name' => 'String value',
                    ],
                ],
                1 => [
                    'type' => 'teams',
                    'id' => 'mock-id-2',
                    'attributes' => [
                        'externalId' => 'mock-id-123',
                        'name' => 'String value',
                    ],
                ],
            ],
        ], 200),
    ]);

    $request = (new TeamsCollectionRequest);

    $dtoCollection = $this->timaticConnector->paginate($request)->dtoCollection();

    Saloon::assertSent(function (TeamsCollectionRequest $request) {
        $query = $request->query()->all();

        return true;
    });

    expect($dtoCollection)->toHaveCount(2);

    expect($dtoCollection->first())
        ->externalId->toBe('mock-id-123')
        ->name->toBe('String value');
});

it('calls the teamsStore method in the Team resource', function () {
    $mockClient = Saloon::fake([
        TeamsStoreRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = NewTeam::testFactory()->state([
        'externalId' => 'external_id-123',
        'name' => 'test name',
    ])->make();

    $request = new TeamsStoreRequest($dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(TeamsStoreRequest::class);

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

it('calls the teamsShow method in the Team resource', function () {
    Saloon::fake([
        TeamsShowRequest::class => MockResponse::make([
            'data' => [
                'type' => 'teams',
                'id' => 'mock-id-123',
                'attributes' => [
                    'externalId' => 'mock-id-123',
                    'name' => 'String value',
                ],
            ],
        ], 200),
    ]);

    $request = new TeamsShowRequest(
        teamId: null
    );
    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(TeamsShowRequest::class);

    expect($response->status())->toBe(200);

    $dto = $response->dto();

    expect($dto)
        ->externalId->toBe('mock-id-123')
        ->name->toBe('String value');
});

it('calls the teamsDestroy method in the Team resource', function () {
    Saloon::fake([
        TeamsDestroyRequest::class => MockResponse::make([], 200),
    ]);

    $request = new TeamsDestroyRequest(
        teamId: null
    );
    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(TeamsDestroyRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the teamsUpdate method in the Team resource', function () {
    $mockClient = Saloon::fake([
        TeamsUpdateRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = UpdateTeam::testFactory()->state([
        'externalId' => 'external_id-123',
        'name' => 'test name',
    ])->make();

    $request = new TeamsUpdateRequest(teamId: 'test value', data: $dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(TeamsUpdateRequest::class);

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
