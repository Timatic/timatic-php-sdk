<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\User\DeleteUserRequest;
use Timatic\SDK\Requests\User\GetUserRequest;
use Timatic\SDK\Requests\User\GetUsersRequest;
use Timatic\SDK\Requests\User\PatchUserRequest;
use Timatic\SDK\Requests\User\PostUsersRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the getUsers method in the User resource', function () {
    Saloon::fake([
        GetUsersRequest::class => MockResponse::make([
            'data' => [
                0 => [
                    'type' => 'resources',
                    'id' => 'mock-id-1',
                    'attributes' => [
                        'externalId' => 'mock-id-123',
                        'email' => 'test@example.com',
                    ],
                ],
                1 => [
                    'type' => 'resources',
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
        ->filter('externalId', 'test-id-123');

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetUsersRequest::class);

    // Verify filter query parameters are present
    Saloon::assertSent(function (Request $request) {
        $query = $request->query()->all();

        expect($query)->toHaveKey('filter[externalId]', 'test-id-123');

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
    $dto = new \Timatic\SDK\Dto\User;
    $dto->externalId = 'mock-id-123';
    $dto->email = 'test@example.com';
    // todo: add every other DTO field

    $this->timaticConnector->user()->postUsers($dto);
    Saloon::assertSent(PostUsersRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            // POST calls dont have an ID field
            ->data->type->toBe('users')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->externalId->toBe('mock-id-123')
            ->email->toBe('test@example.com')
            );

        return true;
    });
});

it('calls the getUser method in the User resource', function () {
    Saloon::fake([
        GetUserRequest::class => MockResponse::make([
            'data' => [
                'type' => 'resources',
                'id' => 'mock-id-123',
                'attributes' => [
                    'externalId' => 'mock-id-123',
                    'email' => 'test@example.com',
                ],
            ],
        ], 200),
    ]);

    $response = $this->timaticConnector->user()->getUser(
        userId: 'test string'
    );

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

    $response = $this->timaticConnector->user()->deleteUser(
        userId: 'test string'
    );

    Saloon::assertSent(DeleteUserRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the patchUser method in the User resource', function () {
    $mockClient = Saloon::fake([
        PatchUserRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = new \Timatic\SDK\Dto\User;
    $dto->externalId = 'mock-id-123';
    $dto->email = 'test@example.com';
    // todo: add every other DTO field

    $this->timaticConnector->user()->patchUser(userId: 'test string', data: $dto);
    Saloon::assertSent(PatchUserRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('users')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->externalId->toBe('mock-id-123')
            ->email->toBe('test@example.com')
            );

        return true;
    });
});
