<?php

// auto-generated

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Dto\Team;
use Timatic\Dto\UserRequest;
use Timatic\Requests\User\UsersCollectionRequest;
use Timatic\Requests\User\UsersDestroyRequest;
use Timatic\Requests\User\UsersShowRequest;
use Timatic\Requests\User\UsersStoreRequest;
use Timatic\Requests\User\UsersUpdateRequest;
use Timatic\TimaticConnector;

beforeEach(function () {
    $this->timaticConnector = new TimaticConnector;
});

it('calls the usersCollection method in the User resource', function () {
    Saloon::fake([
        UsersCollectionRequest::class => MockResponse::make([
            'data' => [
                0 => [
                    'type' => 'users',
                    'id' => 'mock-id-1',
                    'attributes' => [
                        'externalId' => 'mock-id-123',
                        'email' => 'test@example.com',
                        'givenName' => 'String value',
                        'familyName' => 'String value',
                        'isImpersonated' => true,
                        'impersonatedById' => 42,
                    ],
                    'relationships' => [
                        'permissions' => [
                            'data' => [
                                0 => [
                                    'type' => 'permissions',
                                    'id' => 'related-permissions-1',
                                ],
                            ],
                        ],
                        'team' => [
                            'data' => [
                                'type' => 'teams',
                                'id' => 'related-team-1',
                            ],
                        ],
                    ],
                ],
                1 => [
                    'type' => 'users',
                    'id' => 'mock-id-2',
                    'attributes' => [
                        'externalId' => 'mock-id-123',
                        'email' => 'test@example.com',
                        'givenName' => 'String value',
                        'familyName' => 'String value',
                        'isImpersonated' => true,
                        'impersonatedById' => 42,
                    ],
                    'relationships' => [
                        'permissions' => [
                            'data' => [
                                0 => [
                                    'type' => 'permissions',
                                    'id' => 'related-permissions-1',
                                ],
                            ],
                        ],
                        'team' => [
                            'data' => [
                                'type' => 'teams',
                                'id' => 'related-team-1',
                            ],
                        ],
                    ],
                ],
            ],
            'included' => [
                0 => [
                    'type' => 'permissions',
                    'id' => 'related-permissions-1',
                    'attributes' => [],
                ],
                1 => [
                    'type' => 'teams',
                    'id' => 'related-team-1',
                    'attributes' => [],
                ],
            ],
        ], 200),
    ]);

    $request = (new UsersCollectionRequest(pagesize: 123, pagenumber: 123))
        ->filter('externalId', 'external_id-123')
        ->includePermissions()
        ->includeTeam();

    $dtoCollection = $this->timaticConnector->paginate($request)->dtoCollection();

    Saloon::assertSent(function (UsersCollectionRequest $request) {
        $query = $request->query()->all();
        expect($query)->toHaveKey('filter[externalId]', 'external_id-123');
        expect($query)->toHaveKey('include', 'permissions,team');

        return true;
    });

    expect($dtoCollection)->toHaveCount(2);

    expect($dtoCollection->first())
        ->externalId->toBe('mock-id-123')
        ->email->toBe('test@example.com')
        ->givenName->toBe('String value')
        ->familyName->toBe('String value')
        ->isImpersonated->toBe(true)
        ->impersonatedById->toBe(42)
        ->permissions->not->toBeNull()
        ->team->toBeInstanceOf(Team::class);
});

it('calls the usersStore method in the User resource', function () {
    $mockClient = Saloon::fake([
        UsersStoreRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = UserRequest::testFactory()->state([
        'externalId' => 'external_id-123',
        'email' => 'test@example.com',
    ])->make();

    $request = new UsersStoreRequest($dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(UsersStoreRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('users')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->externalId->toBe('external_id-123')
            ->email->toBe('test@example.com')
            );

        return true;
    });
});

it('calls the usersShow method in the User resource', function () {
    Saloon::fake([
        UsersShowRequest::class => MockResponse::make([
            'data' => [
                'type' => 'users',
                'id' => 'mock-id-123',
                'attributes' => [
                    'externalId' => 'mock-id-123',
                    'email' => 'test@example.com',
                    'givenName' => 'String value',
                    'familyName' => 'String value',
                    'isImpersonated' => true,
                    'impersonatedById' => 42,
                ],
            ],
        ], 200),
    ]);

    $request = new UsersShowRequest(
        userId: null
    );
    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(UsersShowRequest::class);

    expect($response->status())->toBe(200);

    $dto = $response->dto();

    expect($dto)
        ->externalId->toBe('mock-id-123')
        ->email->toBe('test@example.com')
        ->givenName->toBe('String value')
        ->familyName->toBe('String value')
        ->isImpersonated->toBe(true)
        ->impersonatedById->toBe(42);
});

it('calls the usersDestroy method in the User resource', function () {
    Saloon::fake([
        UsersDestroyRequest::class => MockResponse::make([], 200),
    ]);

    $request = new UsersDestroyRequest(
        userId: null
    );
    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(UsersDestroyRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the usersUpdate method in the User resource', function () {
    $mockClient = Saloon::fake([
        UsersUpdateRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = UserRequest::testFactory()->state([
        'externalId' => 'external_id-123',
        'email' => 'test@example.com',
    ])->make();

    $request = new UsersUpdateRequest(userId: 'test value', data: $dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(UsersUpdateRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('users')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->externalId->toBe('external_id-123')
            ->email->toBe('test@example.com')
            );

        return true;
    });
});
