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
    $dto->name = 'test value';

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
    $dto = new \Timatic\SDK\Dto\Correction;
    $dto->name = 'test value';

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
