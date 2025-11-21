<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\Correction\PatchCorrectionRequest;
use Timatic\SDK\Requests\Correction\PostCorrectionsRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the postCorrections method in the Correction resource', function () {
    Saloon::fake([
        PostCorrectionsRequest::class => MockResponse::make([], 200),
    ]);

    $response = $this->timaticConnector->correction()->postCorrections(

    );

    Saloon::assertSent(PostCorrectionsRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the patchCorrection method in the Correction resource', function () {
    Saloon::fake([
        PatchCorrectionRequest::class => MockResponse::make([], 200),
    ]);

    $response = $this->timaticConnector->correction()->patchCorrection(
        correctionId: 'test string'
    );

    Saloon::assertSent(PatchCorrectionRequest::class);

    expect($response->status())->toBe(200);
});
