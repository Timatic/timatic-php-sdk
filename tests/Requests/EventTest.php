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
    $dto->userId = 'test-id-123';
    $dto->budgetId = 'test-id-123';
    $dto->ticketId = 'test-id-123';
    $dto->sourceId = 'test-id-123';
    // todo: add every other DTO field

    $this->timaticConnector->event()->postEvents($dto);
    Saloon::assertSent(PostEventsRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            // POST calls dont have an ID field
            ->data->type->toBe('event')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->userId->toBe('test-id-123')
            ->budgetId->toBe('test-id-123')
            ->ticketId->toBe('test-id-123')
            ->sourceId->toBe('test-id-123')
            );

        return true;
    });
});
