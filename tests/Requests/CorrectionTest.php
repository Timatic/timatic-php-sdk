<?php

// auto-generated

use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Requests\Correction\PatchCorrectionRequest;
use Timatic\Requests\Correction\PostCorrectionsRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\TimaticConnector;
});

it('calls the postCorrections method in the Correction resource', function () {
    $mockClient = Saloon::fake([
        PostCorrectionsRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = \Timatic\Dto\Correction::factory()->state([
        'name' => 'test value',
    ])->make();

    $request = new PostCorrectionsRequest($dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(PostCorrectionsRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('corrections');

        return true;
    });
});

it('calls the patchCorrection method in the Correction resource', function () {
    $mockClient = Saloon::fake([
        PatchCorrectionRequest::class => MockResponse::make([], 200),
    ]);

    // Create DTO with sample data
    $dto = \Timatic\Dto\Correction::factory()->state([
        'name' => 'test value',
    ])->make();

    $request = new PatchCorrectionRequest(correctionId: 'test string', data: $dto);
    $this->timaticConnector->send($request);

    Saloon::assertSent(PatchCorrectionRequest::class);

    $mockClient->assertSent(function (Request $request) {
        expect($request->body()->all())
            ->toHaveKey('data')
            ->data->type->toBe('corrections');

        return true;
    });
});
