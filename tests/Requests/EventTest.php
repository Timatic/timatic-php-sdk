<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\Event\PostEventsRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the postEvents method in the Event resource', function () {
    $mockClient = Saloon::fake([
        PostEventsRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = new \Timatic\SDK\Dto\Event;
    $dto->userId = 'mock-id-123';
    $dto->budgetId = 'mock-id-123';
    $dto->ticketId = 'mock-id-123';
    $dto->sourceId = 'mock-id-123';
    // todo: add every other DTO field

    $this->timaticConnector->event()->postEvents($dto);
    Saloon::assertSent(PostEventsRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            // POST calls dont have an ID field
            ->data->type->toBe('event')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->userId->toBe('mock-id-123')
            ->budgetId->toBe('mock-id-123')
            ->ticketId->toBe('mock-id-123')
            ->sourceId->toBe('mock-id-123')
            );

        return true;
    });
});
