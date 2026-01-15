<?php

// auto-generated

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Requests\Permission\PermissionsDestroyRequest;
use Timatic\Requests\Permission\PermissionsShowRequest;
use Timatic\Requests\Permission\PermissionsStoreRequest;
use Timatic\Requests\Permission\PermissionsUpdateRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\TimaticConnector;
});

it('calls the permissionsStore method in the Permission resource', function () {
    $mockClient = Saloon::fake([
        PermissionsStoreRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = \Timatic\Dto\Permission::factory()->state([
        'name' => 'test value',
    ])->make();

    $request = new PermissionsStoreRequest($dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(PermissionsStoreRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('permissions');

        return true;
    });
});

it('calls the permissionsShow method in the Permission resource', function () {
    Saloon::fake([
        PermissionsShowRequest::class => MockResponse::make([
            'data' => [
                'type' => 'permissions',
                'id' => 'mock-id-123',
                'attributes' => [
                    'name' => 'Mock value',
                ],
            ],
        ], 200),
    ]);

    $request = new PermissionsShowRequest(
        permissionId: 123
    );
    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(PermissionsShowRequest::class);

    expect($response->status())->toBe(200);

    $dto = $response->dto();

    expect($dto)
        ->name->toBe('Mock value');
});

it('calls the permissionsDestroy method in the Permission resource', function () {
    Saloon::fake([
        PermissionsDestroyRequest::class => MockResponse::make([], 200),
    ]);

    $request = new PermissionsDestroyRequest(
        permissionId: 123
    );
    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(PermissionsDestroyRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the permissionsUpdate method in the Permission resource', function () {
    $mockClient = Saloon::fake([
        PermissionsUpdateRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = \Timatic\Dto\Permission::factory()->state([
        'name' => 'test value',
    ])->make();

    $request = new PermissionsUpdateRequest(permissionId: 42, data: $dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(PermissionsUpdateRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('permissions');

        return true;
    });
});
