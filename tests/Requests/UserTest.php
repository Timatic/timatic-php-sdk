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
        GetUsersRequest::class => MockResponse::fixture('user.getUsers'),
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
});

it('calls the postUsers method in the User resource', function () {
    Saloon::fake([
        PostUsersRequest::class => MockResponse::fixture('user.postUsers'),
    ]);

    $response = $this->timaticConnector->user()->postUsers(

    );

    Saloon::assertSent(PostUsersRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the getUser method in the User resource', function () {
    Saloon::fake([
        GetUserRequest::class => MockResponse::fixture('user.getUser'),
    ]);

    $response = $this->timaticConnector->user()->getUser(
        userId: 'test string'
    );

    Saloon::assertSent(GetUserRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the deleteUser method in the User resource', function () {
    Saloon::fake([
        DeleteUserRequest::class => MockResponse::fixture('user.deleteUser'),
    ]);

    $response = $this->timaticConnector->user()->deleteUser(
        userId: 'test string'
    );

    Saloon::assertSent(DeleteUserRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the patchUser method in the User resource', function () {
    Saloon::fake([
        PatchUserRequest::class => MockResponse::fixture('user.patchUser'),
    ]);

    $response = $this->timaticConnector->user()->patchUser(
        userId: 'test string'
    );

    Saloon::assertSent(PatchUserRequest::class);

    expect($response->status())->toBe(200);
});
