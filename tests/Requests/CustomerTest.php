<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\Customer\DeleteCustomerRequest;
use Timatic\SDK\Requests\Customer\GetCustomerRequest;
use Timatic\SDK\Requests\Customer\GetCustomersRequest;
use Timatic\SDK\Requests\Customer\PatchCustomerRequest;
use Timatic\SDK\Requests\Customer\PostCustomersRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the getCustomers method in the Customer resource', function () {
    Saloon::fake([
        GetCustomersRequest::class => MockResponse::make([
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

    $request = (new GetCustomersRequest)
        ->filter('externalId', 'test-id-123');

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetCustomersRequest::class);

    // Verify filter query parameters are present
    Saloon::assertSent(function (Request $request) {
        $query = $request->query()->all();

        expect($query)->toHaveKey('filter[externalId]', 'test-id-123');

        return true;
    });

    expect($response->status())->toBe(200);
});

it('calls the postCustomers method in the Customer resource', function () {
    Saloon::fake([
        PostCustomersRequest::class => MockResponse::make([], 200),
    ]);

    $response = $this->timaticConnector->customer()->postCustomers(

    );

    Saloon::assertSent(PostCustomersRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the getCustomer method in the Customer resource', function () {
    Saloon::fake([
        GetCustomerRequest::class => MockResponse::make([
            'data' => [
                'type' => 'resources',
                'id' => 'mock-id-123',
                'attributes' => [
                    'data' => 'Mock value',
                ],
            ],
        ], 200),
    ]);

    $response = $this->timaticConnector->customer()->getCustomer(
        customerId: 'test string'
    );

    Saloon::assertSent(GetCustomerRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the deleteCustomer method in the Customer resource', function () {
    Saloon::fake([
        DeleteCustomerRequest::class => MockResponse::make([], 200),
    ]);

    $response = $this->timaticConnector->customer()->deleteCustomer(
        customerId: 'test string'
    );

    Saloon::assertSent(DeleteCustomerRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the patchCustomer method in the Customer resource', function () {
    Saloon::fake([
        PatchCustomerRequest::class => MockResponse::make([], 200),
    ]);

    $response = $this->timaticConnector->customer()->patchCustomer(
        customerId: 'test string'
    );

    Saloon::assertSent(PatchCustomerRequest::class);

    expect($response->status())->toBe(200);
});
