<?php

// auto-generated

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Requests\Correction\CorrectionsStoreRequest;
use Timatic\Requests\Correction\CorrectionsUpdateRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\TimaticConnector;
});

it('calls the correctionsStore method in the Correction resource', function () {
    $mockClient = Saloon::fake([
        CorrectionsStoreRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = \Timatic\Dto\Correction::factory()->state([
        'name' => 'test value',
    ])->make();

    $request = new CorrectionsStoreRequest($dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(CorrectionsStoreRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('corrections');

        return true;
    });
});

it('calls the correctionsUpdate method in the Correction resource', function () {
    $mockClient = Saloon::fake([
        CorrectionsUpdateRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = \Timatic\Dto\Correction::factory()->state([
        'name' => 'test value',
    ])->make();

    $request = new CorrectionsUpdateRequest(correctionId: 42, data: $dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(CorrectionsUpdateRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('corrections');

        return true;
    });
});
