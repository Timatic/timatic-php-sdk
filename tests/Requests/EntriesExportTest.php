<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\EntriesExport\GetBudgetEntriesExportRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the getBudgetEntriesExport method in the EntriesExport resource', function () {
    Saloon::fake([
        GetBudgetEntriesExportRequest::class => MockResponse::fixture('entriesExport.getBudgetEntriesExport'),
    ]);

    $response = $this->timaticConnector->entriesExport()->getBudgetEntriesExport(
        budgetId: 'test string',
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

    Saloon::assertSent(GetBudgetEntriesExportRequest::class);

    expect($response->status())->toBe(200);
});
