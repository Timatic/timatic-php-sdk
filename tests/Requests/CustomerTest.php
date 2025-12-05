<?php

// auto-generated

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Requests\Customer\DeleteCustomerRequest;
use Timatic\Requests\Customer\GetCustomerRequest;
use Timatic\Requests\Customer\GetCustomersRequest;
use Timatic\Requests\Customer\PatchCustomerRequest;
use Timatic\Requests\Customer\PostCustomersRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\TimaticConnector;
});

it('calls the getCustomers method in the Customer resource', function () {
    Saloon::fake([
        GetCustomersRequest::class => MockResponse::make([
            'data' => [
                0 => [
                    'type' => 'customers',
                    'id' => 'mock-id-1',
                    'attributes' => [
                        'externalId' => 'mock-id-123',
                        'name' => 'Mock value',
                        'hourlyRate' => 'Mock value',
                        'accountManagerUserId' => 'mock-id-123',
                    ],
                ],
                1 => [
                    'type' => 'customers',
                    'id' => 'mock-id-2',
                    'attributes' => [
                        'externalId' => 'mock-id-123',
                        'name' => 'Mock value',
                        'hourlyRate' => 'Mock value',
                        'accountManagerUserId' => 'mock-id-123',
                    ],
                ],
            ],
        ], 200),
    ]);

    $request = (new GetCustomersRequest)
        ->filter('externalId', 'external_id-123');

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetCustomersRequest::class);

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
        ->name->toBe('Mock value')
        ->hourlyRate->toBe('Mock value')
        ->accountManagerUserId->toBe('mock-id-123');
});

it('calls the postCustomers method in the Customer resource', function () {
    $mockClient = Saloon::fake([
        PostCustomersRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = \Timatic\Dto\Customer::factory()->state([
        'externalId' => 'external_id-123',
        'name' => 'test name',
        'hourlyRate' => 'test value',
        'accountManagerUserId' => 'account_manager_user_id-123',
    ])->make();

    $request = new PostCustomersRequest($dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(PostCustomersRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('customers')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->externalId->toBe('external_id-123')
            ->name->toBe('test name')
            ->hourlyRate->toBe('test value')
            ->accountManagerUserId->toBe('account_manager_user_id-123')
            );

        return true;
    });
});

it('calls the getCustomer method in the Customer resource', function () {
    Saloon::fake([
        GetCustomerRequest::class => MockResponse::make([
            'data' => [
                'type' => 'customers',
                'id' => 'mock-id-123',
                'attributes' => [
                    'externalId' => 'mock-id-123',
                    'name' => 'Mock value',
                    'hourlyRate' => 'Mock value',
                    'accountManagerUserId' => 'mock-id-123',
                ],
            ],
        ], 200),
    ]);

    $request = new GetCustomerRequest(
        customerId: 'test string'
    );
    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetCustomerRequest::class);

    expect($response->status())->toBe(200);

    $dto = $response->dto();

    expect($dto)
        ->externalId->toBe('mock-id-123')
        ->name->toBe('Mock value')
        ->hourlyRate->toBe('Mock value')
        ->accountManagerUserId->toBe('mock-id-123');
});

it('calls the deleteCustomer method in the Customer resource', function () {
    Saloon::fake([
        DeleteCustomerRequest::class => MockResponse::make([], 200),
    ]);

    $request = new DeleteCustomerRequest(
        customerId: 'test string'
    );
    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(DeleteCustomerRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the patchCustomer method in the Customer resource', function () {
    $mockClient = Saloon::fake([
        PatchCustomerRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = \Timatic\Dto\Customer::factory()->state([
        'externalId' => 'external_id-123',
        'name' => 'test name',
        'hourlyRate' => 'test value',
        'accountManagerUserId' => 'account_manager_user_id-123',
    ])->make();

    $request = new PatchCustomerRequest(customerId: 'test string', data: $dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(PatchCustomerRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('customers')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->externalId->toBe('external_id-123')
            ->name->toBe('test name')
            ->hourlyRate->toBe('test value')
            ->accountManagerUserId->toBe('account_manager_user_id-123')
            );

        return true;
    });
});
