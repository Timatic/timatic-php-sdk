<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Timatic\SDK\Requests\Approve\PostOvertimeApproveRequest;

beforeEach(function () {
    $this->timaticConnector = new Timatic\SDK\TimaticConnector;
});

it('calls the postOvertimeApprove method in the Approve resource', function () {
    Saloon::fake([
        PostOvertimeApproveRequest::class => MockResponse::fixture('approve.postOvertimeApprove'),
    ]);

    $response = $this->timaticConnector->approve()->postOvertimeApprove(
        overtime: 'test string'
    );

    Saloon::assertSent(PostOvertimeApproveRequest::class);

    expect($response->status())->toBe(200);
});
