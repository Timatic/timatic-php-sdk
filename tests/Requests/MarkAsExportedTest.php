<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\MarkAsExported\PostOvertimeMarkAsExportedRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the postOvertimeMarkAsExported method in the MarkAsExported resource', function () {
    $mockClient = Saloon::fake([
        PostOvertimeMarkAsExportedRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = new \Timatic\SDK\Dto\MarkAsExported;
    $dto->name = 'test value';
    // todo: add every other DTO field

    $this->timaticConnector->markAsExported()->postOvertimeMarkAsExported(overtimeId: 'test string', $dto);
    Saloon::assertSent(PostOvertimeMarkAsExportedRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            // POST calls dont have an ID field
            ->data->type->toBe('markAsExported')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->name->toBe('test value')
            );

        return true;
    });
});
