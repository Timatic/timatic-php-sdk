<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\Entry\DeleteEntryRequest;
use Timatic\SDK\Requests\Entry\GetEntriesRequest;
use Timatic\SDK\Requests\Entry\GetEntryRequest;
use Timatic\SDK\Requests\Entry\PatchEntryRequest;
use Timatic\SDK\Requests\Entry\PostEntriesRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the getEntries method in the Entry resource', function () {
    Saloon::fake([
        GetEntriesRequest::class => MockResponse::fixture('entry.getEntries'),
    ]);

    $response = $this->timaticConnector->entry()->getEntries(
        filteruserId: 'test string',
        filteruserIdeq: 'test string',
        filteruserIdnq: 'test string',
        filteruserIdgt: 'test string',
        filteruserIdlt: 'test string',
        filteruserIdgte: 'test string',
        filteruserIdlte: 'test string',
        filteruserIdcontains: 'test string',
        filterbudgetId: 'test string',
        filterbudgetIdeq: 'test string',
        filterbudgetIdnq: 'test string',
        filterbudgetIdgt: 'test string',
        filterbudgetIdlt: 'test string',
        filterbudgetIdgte: 'test string',
        filterbudgetIdlte: 'test string',
        filterbudgetIdcontains: 'test string',
        filterstartedAt: 'test string',
        filterstartedAteq: 'test string',
        filterstartedAtnq: 'test string',
        filterstartedAtgt: 'test string',
        filterstartedAtlt: 'test string',
        filterstartedAtgte: 'test string',
        filterstartedAtlte: 'test string',
        filterstartedAtcontains: 'test string',
        filterendedAt: 'test string',
        filterendedAteq: 'test string',
        filterendedAtnq: 'test string',
        filterendedAtgt: 'test string',
        filterendedAtlt: 'test string',
        filterendedAtgte: 'test string',
        filterendedAtlte: 'test string',
        filterendedAtcontains: 'test string',
        filterhasOvertime: 'test string',
        filterhasOvertimeeq: 'test string',
        filterhasOvertimenq: 'test string',
        filterhasOvertimegt: 'test string',
        filterhasOvertimelt: 'test string',
        filterhasOvertimegte: 'test string',
        filterhasOvertimelte: 'test string',
        filterhasOvertimecontains: 'test string',
        filteruserFullName: 'test string',
        filteruserFullNameeq: 'test string',
        filteruserFullNamenq: 'test string',
        filteruserFullNamegt: 'test string',
        filteruserFullNamelt: 'test string',
        filteruserFullNamegte: 'test string',
        filteruserFullNamelte: 'test string',
        filteruserFullNamecontains: 'test string',
        filtercustomerId: 'test string',
        filtercustomerIdeq: 'test string',
        filtercustomerIdnq: 'test string',
        filtercustomerIdgt: 'test string',
        filtercustomerIdlt: 'test string',
        filtercustomerIdgte: 'test string',
        filtercustomerIdlte: 'test string',
        filtercustomerIdcontains: 'test string',
        filterticketNumber: 'test string',
        filterticketNumbereq: 'test string',
        filterticketNumbernq: 'test string',
        filterticketNumbergt: 'test string',
        filterticketNumberlt: 'test string',
        filterticketNumbergte: 'test string',
        filterticketNumberlte: 'test string',
        filterticketNumbercontains: 'test string',
        filtersettlement: 'test string',
        filterisInvoiced: 'test string',
        filterisInvoiceable: 'test string',
        include: 'test string'
    );

    Saloon::assertSent(GetEntriesRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the postEntries method in the Entry resource', function () {
    Saloon::fake([
        PostEntriesRequest::class => MockResponse::fixture('entry.postEntries'),
    ]);

    $response = $this->timaticConnector->entry()->postEntries(

    );

    Saloon::assertSent(PostEntriesRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the getEntry method in the Entry resource', function () {
    Saloon::fake([
        GetEntryRequest::class => MockResponse::fixture('entry.getEntry'),
    ]);

    $response = $this->timaticConnector->entry()->getEntry(
        entryId: 'test string'
    );

    Saloon::assertSent(GetEntryRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the deleteEntry method in the Entry resource', function () {
    Saloon::fake([
        DeleteEntryRequest::class => MockResponse::fixture('entry.deleteEntry'),
    ]);

    $response = $this->timaticConnector->entry()->deleteEntry(
        entryId: 'test string'
    );

    Saloon::assertSent(DeleteEntryRequest::class);

    expect($response->status())->toBe(200);
});

it('calls the patchEntry method in the Entry resource', function () {
    Saloon::fake([
        PatchEntryRequest::class => MockResponse::fixture('entry.patchEntry'),
    ]);

    $response = $this->timaticConnector->entry()->patchEntry(
        entryId: 'test string'
    );

    Saloon::assertSent(PatchEntryRequest::class);

    expect($response->status())->toBe(200);
});
