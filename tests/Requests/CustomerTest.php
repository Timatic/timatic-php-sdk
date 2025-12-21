<?php

// auto-generated

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Requests\Customer\CustomersCollectionRequest;
use Timatic\Requests\Customer\CustomersDestroyRequest;
use Timatic\Requests\Customer\CustomersShowRequest;
use Timatic\Requests\Customer\CustomersStoreRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\TimaticConnector;
});

it('calls the customersCollection method in the Customer resource', function () {
    Saloon::fake([
        CustomersCollectionRequest::class => MockResponse::make([
            'data' => [
                0 => [
                    'type' => 'customers',
                    'id' => 'mock-id-1',
                    'attributes' => [
                        'externalId' => 'mock-id-123',
                        'name' => 'Mock value',
                        'hourlyRate' => 'Mock value',
                        'accountManagerUserId' => 42,
                    ],
                ],
                1 => [
                    'type' => 'customers',
                    'id' => 'mock-id-2',
                    'attributes' => [
                        'externalId' => 'mock-id-123',
                        'name' => 'Mock value',
                        'hourlyRate' => 'Mock value',
                        'accountManagerUserId' => 42,
                    ],
                ],
            ],
        ], 200),
    ]);

    $request = (new CustomersCollectionRequest(pagesize: 123, pagenumber: 123))
        ->filter('externalId', 'external_id-123');

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(function (CustomersCollectionRequest $request) {
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
        ->accountManagerUserId->toBe(42);
});

it('calls the customersStore method in the Customer resource', function () {
    $mockClient = Saloon::fake([
        CustomersStoreRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = \Timatic\Dto\Customer::factory()->state([
        'externalId' => 'external_id-123',
        'name' => 'test name',
        'hourlyRate' => 'test value',
        'accountManagerUserId' => 42,
    ])->make();

    $request = new CustomersStoreRequest($dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(CustomersStoreRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('customers')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->externalId->toBe('external_id-123')
            ->name->toBe('test name')
            ->hourlyRate->toBe('test value')
            ->accountManagerUserId->toBe(42)
            );

        return true;
    });
});

it('calls the customersShow method in the Customer resource', function () {
    Saloon::fake([
        CustomersShowRequest::class => MockResponse::make([
            'data' => [
                'type' => 'customers',
                'id' => 'mock-id-123',
                'attributes' => [
                    'externalId' => 'mock-id-123',
                    'name' => 'Mock value',
                    'hourlyRate' => 'Mock value',
                    'accountManagerUserId' => 42,
                ],
            ],
        ], 200),
    ]);

    $request = new CustomersShowRequest(
        customerId: 123
    );
    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(CustomersShowRequest::class);

    expect($response->status())->toBe(200);

    $dto = $response->dto();

    expect($dto)
        ->externalId->toBe('mock-id-123')
        ->name->toBe('Mock value')
        ->hourlyRate->toBe('Mock value')
        ->accountManagerUserId->toBe(42);
});

it('calls the customersDestroy method in the Customer resource', function () {
    Saloon::fake([
        CustomersDestroyRequest::class => MockResponse::make([], 200),
    ]);

    $request = new CustomersDestroyRequest(
        customerId: 123
    );
    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(CustomersDestroyRequest::class);

    expect($response->status())->toBe(200);
});
