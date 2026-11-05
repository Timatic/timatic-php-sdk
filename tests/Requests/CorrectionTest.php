<?php

// auto-generated

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Dto\CorrectionCreateRequest;
use Timatic\Dto\CorrectionUpdateRequest;
use Timatic\Requests\Correction\CorrectionsStoreRequest;
use Timatic\Requests\Correction\CorrectionsUpdateRequest;
use Timatic\TimaticConnector;

beforeEach(function () {
    $this->timaticConnector = new TimaticConnector;
});

it('calls the correctionsStore method in the Correction resource', function () {
    $mockClient = Saloon::fake([
        CorrectionsStoreRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = CorrectionCreateRequest::testFactory()->state([
        'correctedEntryId' => 42,
        'newEntryId' => 42,
    ])->make();

    $request = new CorrectionsStoreRequest($dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(CorrectionsStoreRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('corrections')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->correctedEntryId->toBe(42)
            ->newEntryId->toBe(42)
            );

        return true;
    });
});

it('calls the correctionsUpdate method in the Correction resource', function () {
    $mockClient = Saloon::fake([
        CorrectionsUpdateRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = CorrectionUpdateRequest::testFactory()->state([
        'newEntryId' => 42,
    ])->make();

    $request = new CorrectionsUpdateRequest(correctionId: 'test value', data: $dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(CorrectionsUpdateRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('corrections')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->newEntryId->toBe(42)
            );

        return true;
    });
});
