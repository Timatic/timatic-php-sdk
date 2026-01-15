<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Timatic\Dto\Team;
use Timatic\Dto\User;
use Timatic\Hydration\Facades\Hydrator;

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

    $user = Hydrator::hydrate(User::class, $jsonApiResponse['data'], $jsonApiResponse['included']);

    expect($user)->toBeInstanceOf(User::class)
        ->and($user->id)->toBe('1')
        ->and($user->email)->toBe('john@example.com')
        ->and($user->team)->toBeInstanceOf(Team::class)
        ->and($user->team->id)->toBe('10')
        ->and($user->team->name)->toBe('Engineering');
});

it('serializes a single relationship (to-one) to JSON:API format', function () {
    $team = new Team([
        'name' => 'Engineering',
    ]);
    $team->id = '10';

    $user = new User([
        'email' => 'john@example.com',
        'givenName' => 'John',
        'familyName' => 'Doe',
    ]);
    $user->id = '1';
    $user->team = $team;

    $jsonApi = $user->toJsonApi();

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
    // Create a user with multiple permissions
    $user = new User([
        'email' => 'john@example.com',
        'givenName' => 'John',
        'familyName' => 'Doe',
    ]);
    $user->id = '1';

    $permission1 = new \Timatic\Dto\Permission;
    $permission1->id = 'p1';

    $permission2 = new \Timatic\Dto\Permission;
    $permission2->id = 'p2';

    $user->permissions = new Collection([$permission1, $permission2]);

    $jsonApi = $user->toJsonApi();

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

it('does not serialize uninitialized relationships', function () {
    $user = new User([
        'email' => 'john@example.com',
        'givenName' => 'John',
        'familyName' => 'Doe',
    ]);
    $user->id = '1';

    $jsonApi = $user->toJsonApi();

    expect($jsonApi)->not->toHaveKey('relationships');
});

it('does not serialize null relationships', function () {
    $user = new User([
        'email' => 'john@example.com',
        'givenName' => 'John',
        'familyName' => 'Doe',
    ]);
    $user->id = '1';
    $user->team = null;
    $user->permissions = null;

    $jsonApi = $user->toJsonApi();

    expect($jsonApi)->not->toHaveKey('relationships');
});
