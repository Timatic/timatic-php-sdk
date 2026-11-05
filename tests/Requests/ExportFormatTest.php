<?php

// auto-generated

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\Requests\ExportFormat\ExportFormatsCollectionRequest;
use Timatic\TimaticConnector;

beforeEach(function () {
    $this->timaticConnector = new TimaticConnector;
});

it('calls the exportFormatsCollection method in the ExportFormat resource', function () {
    Saloon::fake([
        ExportFormatsCollectionRequest::class => MockResponse::make([
            'data' => [
                0 => [
                    'type' => 'exportFormats',
                    'id' => 'mock-id-1',
                    'attributes' => [
                        'label' => 'String value',
                        'periodOptions' => 'String value',
                        'extension' => 'String value',
                    ],
                ],
                1 => [
                    'type' => 'exportFormats',
                    'id' => 'mock-id-2',
                    'attributes' => [
                        'label' => 'String value',
                        'periodOptions' => 'String value',
                        'extension' => 'String value',
                    ],
                ],
            ],
        ], 200),
    ]);

    $request = (new ExportFormatsCollectionRequest);

    $dtoCollection = $this->timaticConnector->paginate($request)->dtoCollection();

    Saloon::assertSent(function (ExportFormatsCollectionRequest $request) {
        $query = $request->query()->all();

        return true;
    });

    expect($dtoCollection)->toHaveCount(2);

    expect($dtoCollection->first())
        ->label->toBe('String value')
        ->periodOptions->toBe('String value')
        ->extension->toBe('String value');
});
