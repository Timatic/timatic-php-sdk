<?php

// auto-generated

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Requests\User\DeleteUserRequest;
use Timatic\Requests\User\GetUserRequest;
use Timatic\Requests\User\GetUsersRequest;
use Timatic\Requests\User\PatchUserRequest;
use Timatic\Requests\User\PostUsersRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\TimaticConnector;
});

it('calls the getUsers method in the User resource', function () {
    Saloon::fake([
        GetUsersRequest::class => MockResponse::make([
            'data' => [
                0 => [
                    'type' => 'users',
                    'id' => 'mock-id-1',
                    'attributes' => [
                        'externalId' => 'mock-id-123',
                        'email' => 'test@example.com',
                    ],
                ],
                1 => [
                    'type' => 'users',
                    'id' => 'mock-id-2',
                    'attributes' => [
                        'externalId' => 'mock-id-123',
                        'email' => 'test@example.com',
                    ],
                ],
            ],
        ], 200),
    ]);

    $request = (new GetUsersRequest)
        ->filter('externalId', 'external_id-123');

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetUsersRequest::class);

    // Verify filter query parameters are present
    Saloon::assertSent(function (Request $request) {
        $query = $request->query()->all();

        expect($query)->toHaveKey('filter[externalId]', 'external_id-123');

        return true;
    });

    expect($response->status())->toBe(200);

    $dtoCollection = $response->dto();

    expect($dtoCollection->first())
        ->externalId->toBe('mock-id-123')
        ->email->toBe('test@example.com');
});

it('calls the postUsers method in the User resource', function () {
    $mockClient = Saloon::fake([
        PostUsersRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = \Timatic\Dto\User::factory()->state([
        'externalId' => 'external_id-123',
        'email' => 'test@example.com',
    ])->make();

    $request = new PostUsersRequest($dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(PostUsersRequest::class);

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

it('calls the getUser method in the User resource', function () {
    Saloon::fake([
        GetUserRequest::class => MockResponse::make([
            'data' => [
                'type' => 'users',
                'id' => 'mock-id-123',
                'attributes' => [
                    'externalId' => 'mock-id-123',
                    'email' => 'test@example.com',
                ],
            ],
        ], 200),
    ]);

    $request = new GetUserRequest(
        userId: 'test string'
    );
    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetUserRequest::class);

    expect($response->status())->toBe(200);

    $dto = $response->dto();

    expect($dto)
        ->externalId->toBe('mock-id-123')
        ->email->toBe('test@example.com');
});

it('calls the deleteUser method in the User resource', function () {
    Saloon::fake([
        DeleteUserRequest::class => MockResponse::make([], 200),
    ]);

    $request = new DeleteUserRequest(
        userId: 'test string'
    );
    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(DeleteUserRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the patchUser method in the User resource', function () {
    $mockClient = Saloon::fake([
        PatchUserRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = \Timatic\Dto\User::factory()->state([
        'externalId' => 'external_id-123',
        'email' => 'test@example.com',
    ])->make();

    $request = new PatchUserRequest(userId: 'test string', data: $dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(PatchUserRequest::class);

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
