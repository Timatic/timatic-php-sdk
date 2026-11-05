<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Timatic\Dto\Permission;
use Timatic\Dto\Team;
use Timatic\Dto\User;
use Timatic\Foundation\JsonApi\JsonApiSerializer;
use Timatic\Foundation\JsonApi\JsonApiTransformer;

it('hydrates a single relationship (to-one)', function () {
    $jsonApiResponse = [
        'data' => [
            'type' => 'users',
            'id' => '1',
            'attributes' => [
                'email' => 'john@example.com',
                'givenName' => 'John',
                'familyName' => 'Doe',
            ],
            'relationships' => [
                'team' => [
                    'data' => [
                        'type' => 'teams',
                        'id' => '10',
                    ],
                ],
            ],
        ],
        'included' => [
            [
                'type' => 'teams',
                'id' => '10',
                'attributes' => [
                    'name' => 'Engineering',
                ],
            ],
        ],
    ];

    $user = User::from(JsonApiTransformer::flatten(User::class, $jsonApiResponse['data'], $jsonApiResponse['included']));

    expect($user)->toBeInstanceOf(User::class)
        ->and($user->id)->toBe('1')
        ->and($user->email)->toBe('john@example.com')
        ->and($user->team)->toBeInstanceOf(Team::class)
        ->and($user->team->id)->toBe('10')
        ->and($user->team->name)->toBe('Engineering');
});

it('serializes a single relationship (to-one) to JSON:API format', function () {
    $team = new Team(id: '10', name: 'Engineering');

    $user = new User(id: '1', email: 'john@example.com', givenName: 'John', familyName: 'Doe');
    $user->team = $team;

    $jsonApi = JsonApiSerializer::toJsonApi($user);

    expect($jsonApi)->toHaveKey('relationships')
        ->and($jsonApi['relationships'])->toHaveKey('team')
        ->and($jsonApi['relationships']['team'])->toBe([
            'data' => [
                'type' => 'teams',
                'id' => '10',
            ],
        ]);
});

it('serializes multiple relationships (to-many) to JSON:API format', function () {
    $user = new User(id: '1', email: 'john@example.com', givenName: 'John', familyName: 'Doe');

    $permission1 = new Permission(id: 'p1');

    $permission2 = new Permission(id: 'p2');

    $user->permissions = new Collection([$permission1, $permission2]);

    $jsonApi = JsonApiSerializer::toJsonApi($user);

    expect($jsonApi)->toHaveKey('relationships')
        ->and($jsonApi['relationships'])->toHaveKey('permissions')
        ->and($jsonApi['relationships']['permissions'])->toBe([
            'data' => [
                [
                    'type' => 'permissions',
                    'id' => 'p1',
                ],
                [
                    'type' => 'permissions',
                    'id' => 'p2',
                ],
            ],
        ]);
});

it('does not serialize null relationships', function () {
    $user = new User(id: '1', email: 'john@example.com', givenName: 'John', familyName: 'Doe');

    $jsonApi = JsonApiSerializer::toJsonApi($user);

    expect($jsonApi)->not->toHaveKey('relationships');
});
