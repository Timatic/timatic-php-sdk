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
                        'externalId' => 'mock-id-123',
                        'name' => 'Mock value',
                        'hourlyRate' => 'Mock value',
                        'accountManagerUserId' => 'mock-id-123',
                    ],
                ],
                1 => [
                    'type' => 'resources',
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
    $dto = new \Timatic\SDK\Dto\Customer;
    $dto->externalId = 'mock-id-123';
    $dto->name = 'test value';
    $dto->hourlyRate = 'test value';
    $dto->accountManagerUserId = 'mock-id-123';
    // todo: add every other DTO field

    $this->timaticConnector->customer()->postCustomers($dto);
    Saloon::assertSent(PostCustomersRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            // POST calls dont have an ID field
            ->data->type->toBe('customers')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->externalId->toBe('mock-id-123')
            ->name->toBe('test value')
            ->hourlyRate->toBe('test value')
            ->accountManagerUserId->toBe('mock-id-123')
            );

        return true;
    });
});

it('calls the getCustomer method in the Customer resource', function () {
    Saloon::fake([
        GetCustomerRequest::class => MockResponse::make([
            'data' => [
                'type' => 'resources',
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

    $response = $this->timaticConnector->customer()->getCustomer(
        customerId: 'test string'
    );

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

    $response = $this->timaticConnector->customer()->deleteCustomer(
        customerId: 'test string'
    );

    Saloon::assertSent(DeleteCustomerRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the patchCustomer method in the Customer resource', function () {
    $mockClient = Saloon::fake([
        PatchCustomerRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = new \Timatic\SDK\Dto\Customer;
    $dto->externalId = 'mock-id-123';
    $dto->name = 'test value';
    $dto->hourlyRate = 'test value';
    $dto->accountManagerUserId = 'mock-id-123';
    // todo: add every other DTO field

    $this->timaticConnector->customer()->patchCustomer(customerId: 'test string', data: $dto);
    Saloon::assertSent(PatchCustomerRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('customers')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->externalId->toBe('mock-id-123')
            ->name->toBe('test value')
            ->hourlyRate->toBe('test value')
            ->accountManagerUserId->toBe('mock-id-123')
            );

        return true;
    });
});
