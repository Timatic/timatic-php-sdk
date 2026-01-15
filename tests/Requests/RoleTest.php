<?php

// auto-generated

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Requests\Role\RolesCollectionRequest;
use Timatic\Requests\Role\RolesDestroyRequest;
use Timatic\Requests\Role\RolesShowRequest;
use Timatic\Requests\Role\RolesStoreRequest;
use Timatic\Requests\Role\RolesUpdateRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\TimaticConnector;
});

it('calls the rolesCollection method in the Role resource', function () {
    Saloon::fake([
        RolesCollectionRequest::class => MockResponse::make([
            'data' => [
                0 => [
                    'type' => 'roles',
                    'id' => 'mock-id-1',
                    'attributes' => [
                        'name' => 'Mock value',
                        'guardName' => 'Mock value',
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
                    ],
                ],
                1 => [
                    'type' => 'roles',
                    'id' => 'mock-id-2',
                    'attributes' => [
                        'name' => 'Mock value',
                        'guardName' => 'Mock value',
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
                    ],
                ],
            ],
            'included' => [
                0 => [
                    'type' => 'permissions',
                    'id' => 'related-permissions-1',
                    'attributes' => [],
                ],
            ],
        ], 200),
    ]);

    $request = (new RolesCollectionRequest(pagesize: 123, pagenumber: 123))
        ->includePermissions();

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(function (RolesCollectionRequest $request) {
        $query = $request->query()->all();
        expect($query)->toHaveKey('include', 'permissions');

        return true;
    });

    expect($response->status())->toBe(200);

    $dtoCollection = $response->dto();

    expect($dtoCollection->first())
        ->name->toBe('Mock value')
        ->guardName->toBe('Mock value')
        ->permissions->not->toBeNull();
});

it('calls the rolesStore method in the Role resource', function () {
    $mockClient = Saloon::fake([
        RolesStoreRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = \Timatic\Dto\Role::factory()->state([
        'name' => 'test name',
        'guardName' => 'test value',
    ])->make();

    $request = new RolesStoreRequest($dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(RolesStoreRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('roles')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->name->toBe('test name')
            ->guardName->toBe('test value')
            );

        return true;
    });
});

it('calls the rolesShow method in the Role resource', function () {
    Saloon::fake([
        RolesShowRequest::class => MockResponse::make([
            'data' => [
                'type' => 'roles',
                'id' => 'mock-id-123',
                'attributes' => [
                    'name' => 'Mock value',
                    'guardName' => 'Mock value',
                ],
            ],
        ], 200),
    ]);

    $request = new RolesShowRequest(
        roleId: 123
    );
    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(RolesShowRequest::class);

    expect($response->status())->toBe(200);

    $dto = $response->dto();

    expect($dto)
        ->name->toBe('Mock value')
        ->guardName->toBe('Mock value');
});

it('calls the rolesDestroy method in the Role resource', function () {
    Saloon::fake([
        RolesDestroyRequest::class => MockResponse::make([], 200),
    ]);

    $request = new RolesDestroyRequest(
        roleId: 123
    );
    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(RolesDestroyRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the rolesUpdate method in the Role resource', function () {
    $mockClient = Saloon::fake([
        RolesUpdateRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = \Timatic\Dto\Role::factory()->state([
        'name' => 'test name',
        'guardName' => 'test value',
    ])->make();

    $request = new RolesUpdateRequest(roleId: 42, data: $dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(RolesUpdateRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('roles')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->name->toBe('test name')
            ->guardName->toBe('test value')
            );

        return true;
    });
});
