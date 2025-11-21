<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\Correction\PatchCorrectionRequest;
use Timatic\SDK\Requests\Correction\PostCorrectionsRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the postCorrections method in the Correction resource', function () {
    $mockClient = Saloon::fake([
        PostCorrectionsRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = new \Timatic\SDK\Dto\Correction;
    $dto->createdAt = '2025-01-01T10:00:00Z';
    $dto->updatedAt = '2025-01-01T10:00:00Z';
    // todo: add every other DTO field

    $this->timaticConnector->correction()->postCorrections($dto);
    Saloon::assertSent(PostCorrectionsRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            // POST calls dont have an ID field
            ->data->type->toBe('correction')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->createdAt->toBe('2025-01-01T10:00:00Z')
            ->updatedAt->toBe('2025-01-01T10:00:00Z')
            );

        return true;
    });
});

it('calls the patchCorrection method in the Correction resource', function () {
    $mockClient = Saloon::fake([
        PatchCorrectionRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = new \Timatic\SDK\Dto\Correction;
    $dto->createdAt = '2025-01-01T10:00:00Z';
    $dto->updatedAt = '2025-01-01T10:00:00Z';
    // todo: add every other DTO field

    $this->timaticConnector->correction()->patchCorrection(correctionId: 'test string', $dto);
    Saloon::assertSent(PatchCorrectionRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('correction')
            ->data->attributes->scoped(fn ($attributes) => $attributes
            ->createdAt->toBe('2025-01-01T10:00:00Z')
            ->updatedAt->toBe('2025-01-01T10:00:00Z')
            );

        return true;
    });
});
