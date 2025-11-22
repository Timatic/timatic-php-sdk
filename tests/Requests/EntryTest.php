<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\Entry\DeleteEntryRequest;
use Timatic\SDK\Requests\Entry\GetEntriesRequest;
use Timatic\SDK\Requests\Entry\GetEntryRequest;
use Timatic\SDK\Requests\Entry\PatchEntryRequest;
use Timatic\SDK\Requests\Entry\PostEntriesRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the getEntries method in the Entry resource', function () {
    Saloon::fake([
        GetEntriesRequest::class => MockResponse::make([
            'data' => [
                0 => [
                    'type' => 'entries',
                    'id' => 'mock-id-1',
                    'attributes' => [
                        'ticketId' => 'mock-id-123',
                        'ticketNumber' => 'Mock value',
                        'ticketTitle' => 'Mock value',
                        'ticketType' => 'Mock value',
                        'customerId' => 'mock-id-123',
                        'customerName' => 'Mock value',
                        'hourlyRate' => 'Mock value',
                        'hadEmergencyShift' => true,
                        'budgetId' => 'mock-id-123',
                        'isPaidPerHour' => true,
                        'minutesSpent' => 42,
                        'userId' => 'mock-id-123',
                        'userEmail' => 'test@example.com',
                        'userFullName' => 'Mock value',
                        'createdByUserId' => 'mock-id-123',
                        'createdByUserEmail' => 'test@example.com',
                        'createdByUserFullName' => 'Mock value',
                        'entryType' => 'Mock value',
                        'description' => 'Mock value',
                        'isInternal' => true,
                        'startedAt' => 'Mock value',
                        'endedAt' => 'Mock value',
                        'invoicedAt' => 'Mock value',
                        'isInvoiced' => 'Mock value',
                        'isBasedOnSuggestion' => true,
                    ],
                ],
                1 => [
                    'type' => 'entries',
                    'id' => 'mock-id-2',
                    'attributes' => [
                        'ticketId' => 'mock-id-123',
                        'ticketNumber' => 'Mock value',
                        'ticketTitle' => 'Mock value',
                        'ticketType' => 'Mock value',
                        'customerId' => 'mock-id-123',
                        'customerName' => 'Mock value',
                        'hourlyRate' => 'Mock value',
                        'hadEmergencyShift' => true,
                        'budgetId' => 'mock-id-123',
                        'isPaidPerHour' => true,
                        'minutesSpent' => 42,
                        'userId' => 'mock-id-123',
                        'userEmail' => 'test@example.com',
                        'userFullName' => 'Mock value',
                        'createdByUserId' => 'mock-id-123',
                        'createdByUserEmail' => 'test@example.com',
                        'createdByUserFullName' => 'Mock value',
                        'entryType' => 'Mock value',
                        'description' => 'Mock value',
                        'isInternal' => true,
                        'startedAt' => 'Mock value',
                        'endedAt' => 'Mock value',
                        'invoicedAt' => 'Mock value',
                        'isInvoiced' => 'Mock value',
                        'isBasedOnSuggestion' => true,
                    ],
                ],
            ],
        ], 200),
    ]);

    $request = (new GetEntriesRequest(include: 'test string'))
        ->filter('userId', 'user_id-123')
        ->filter('budgetId', 'budget_id-123')
        ->filter('startedAt', '2025-01-15T10:30:00Z');

    $response = $this->timaticConnector->send($request);

    Saloon::assertSent(GetEntriesRequest::class);

    // Verify filter query parameters are present
    Saloon::assertSent(function (Request $request) {
        $query = $request->query()->all();

        expect($query)->toHaveKey('filter[userId]', 'user_id-123');
        expect($query)->toHaveKey('filter[budgetId]', 'budget_id-123');
        expect($query)->toHaveKey('filter[startedAt]', '2025-01-15T10:30:00Z');

        return true;
    });

    expect($response->status())->toBe(200);

    $dtoCollection = $response->dto();

    expect($dtoCollection->first())
        ->ticketId->toBe('mock-id-123')
        ->ticketNumber->toBe('Mock value')
        ->ticketTitle->toBe('Mock value')
        ->ticketType->toBe('Mock value')
        ->customerId->toBe('mock-id-123')
        ->customerName->toBe('Mock value')
        ->hourlyRate->toBe('Mock value')
        ->hadEmergencyShift->toBe(true)
        ->budgetId->toBe('mock-id-123')
        ->isPaidPerHour->toBe(true)
        ->minutesSpent->toBe(42)
        ->userId->toBe('mock-id-123')
        ->userEmail->toBe('test@example.com')
        ->userFullName->toBe('Mock value')
        ->createdByUserId->toBe('mock-id-123')
        ->createdByUserEmail->toBe('test@example.com')
        ->createdByUserFullName->toBe('Mock value')
        ->entryType->toBe('Mock value')
        ->description->toBe('Mock value')
        ->isInternal->toBe(true)
        ->startedAt->toBe('Mock value')
        ->endedAt->toBe('Mock value')
        ->invoicedAt->toBe('Mock value')
        ->isInvoiced->toBe('Mock value')
        ->isBasedOnSuggestion->toBe(true);
});

it('calls the postEntries method in the Entry resource', function () {
    $mockClient = Saloon::fake([
        PostEntriesRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = new \Timatic\SDK\Dto\Entry;
    $dto->ticketId = 'ticket_id-123';
    $dto->ticketNumber = 'test value';
    $dto->ticketTitle = 'test value';
    $dto->ticketType = 'test value';

    $this->timaticConnector->entry()->postEntries($dto);
    Saloon::assertSent(PostEntriesRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('entries')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->ticketId->toBe('ticket_id-123')
            ->ticketNumber->toBe('test value')
            ->ticketTitle->toBe('test value')
            ->ticketType->toBe('test value')
            );

        return true;
    });
});

it('calls the getEntry method in the Entry resource', function () {
    Saloon::fake([
        GetEntryRequest::class => MockResponse::make([
            'data' => [
                'type' => 'entries',
                'id' => 'mock-id-123',
                'attributes' => [
                    'ticketId' => 'mock-id-123',
                    'ticketNumber' => 'Mock value',
                    'ticketTitle' => 'Mock value',
                    'ticketType' => 'Mock value',
                    'customerId' => 'mock-id-123',
                    'customerName' => 'Mock value',
                    'hourlyRate' => 'Mock value',
                    'hadEmergencyShift' => true,
                    'budgetId' => 'mock-id-123',
                    'isPaidPerHour' => true,
                    'minutesSpent' => 42,
                    'userId' => 'mock-id-123',
                    'userEmail' => 'test@example.com',
                    'userFullName' => 'Mock value',
                    'createdByUserId' => 'mock-id-123',
                    'createdByUserEmail' => 'test@example.com',
                    'createdByUserFullName' => 'Mock value',
                    'entryType' => 'Mock value',
                    'description' => 'Mock value',
                    'isInternal' => true,
                    'startedAt' => 'Mock value',
                    'endedAt' => 'Mock value',
                    'invoicedAt' => 'Mock value',
                    'isInvoiced' => 'Mock value',
                    'isBasedOnSuggestion' => true,
                ],
            ],
        ], 200),
    ]);

    $response = $this->timaticConnector->entry()->getEntry(
        entryId: 'test string'
    );

    Saloon::assertSent(GetEntryRequest::class);

    expect($response->status())->toBe(200);

    $dto = $response->dto();

    expect($dto)
        ->ticketId->toBe('mock-id-123')
        ->ticketNumber->toBe('Mock value')
        ->ticketTitle->toBe('Mock value')
        ->ticketType->toBe('Mock value')
        ->customerId->toBe('mock-id-123')
        ->customerName->toBe('Mock value')
        ->hourlyRate->toBe('Mock value')
        ->hadEmergencyShift->toBe(true)
        ->budgetId->toBe('mock-id-123')
        ->isPaidPerHour->toBe(true)
        ->minutesSpent->toBe(42)
        ->userId->toBe('mock-id-123')
        ->userEmail->toBe('test@example.com')
        ->userFullName->toBe('Mock value')
        ->createdByUserId->toBe('mock-id-123')
        ->createdByUserEmail->toBe('test@example.com')
        ->createdByUserFullName->toBe('Mock value')
        ->entryType->toBe('Mock value')
        ->description->toBe('Mock value')
        ->isInternal->toBe(true)
        ->startedAt->toBe('Mock value')
        ->endedAt->toBe('Mock value')
        ->invoicedAt->toBe('Mock value')
        ->isInvoiced->toBe('Mock value')
        ->isBasedOnSuggestion->toBe(true);
});

it('calls the deleteEntry method in the Entry resource', function () {
    Saloon::fake([
        DeleteEntryRequest::class => MockResponse::make([], 200),
    ]);

    $response = $this->timaticConnector->entry()->deleteEntry(
        entryId: 'test string'
    );

    Saloon::assertSent(DeleteEntryRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the patchEntry method in the Entry resource', function () {
    $mockClient = Saloon::fake([
        PatchEntryRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = new \Timatic\SDK\Dto\Entry;
    $dto->ticketId = 'ticket_id-123';
    $dto->ticketNumber = 'test value';
    $dto->ticketTitle = 'test value';
    $dto->ticketType = 'test value';

    $this->timaticConnector->entry()->patchEntry(entryId: 'test string', data: $dto);
    Saloon::assertSent(PatchEntryRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('entries')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->ticketId->toBe('ticket_id-123')
            ->ticketNumber->toBe('test value')
            ->ticketTitle->toBe('test value')
            ->ticketType->toBe('test value')
            );

        return true;
    });
});
