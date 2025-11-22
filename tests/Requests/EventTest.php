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
    $dto->userId = 'user_id-123';
    $dto->budgetId = 'budget_id-123';
    $dto->ticketId = 'ticket_id-123';
    $dto->sourceId = 'source_id-123';

    $this->timaticConnector->event()->postEvents($dto);
    Saloon::assertSent(PostEventsRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('events')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->userId->toBe('user_id-123')
            ->budgetId->toBe('budget_id-123')
            ->ticketId->toBe('ticket_id-123')
            ->sourceId->toBe('source_id-123')
            );

        return true;
    });
});
