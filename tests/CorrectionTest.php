<?php

// Generated 2025-11-17 21:22:04

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\Correction\PatchCorrectionRequest;
use Timatic\SDK\Requests\Correction\PostCorrectionsRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the postCorrections method in the Correction resource', function () {
    Saloon::fake([
        PostCorrectionsRequest::class => MockResponse::fixture('correction.postCorrections'),
    ]);

    $response = $this->timaticConnector->correction()->postCorrections(

    );

    Saloon::assertSent(PostCorrectionsRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the patchCorrection method in the Correction resource', function () {
    Saloon::fake([
        PatchCorrectionRequest::class => MockResponse::fixture('correction.patchCorrection'),
    ]);

    $response = $this->timaticConnector->correction()->patchCorrection(
        correction: 'test string'
    );

    Saloon::assertSent(PatchCorrectionRequest::class);

    expect($response->status())->toBe(200);
});
