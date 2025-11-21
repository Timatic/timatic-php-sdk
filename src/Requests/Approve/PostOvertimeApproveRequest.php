<?php

namespace Timatic\SDK\Requests\Approve;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Timatic\SDK\Foundation\Model;

/**
 * postOvertimeApprove
 */
class PostOvertimeApproveRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return "/overtimes/{$this->overtimeId}/approve";
    }

    /**
     * @param  null|Timatic\SDK\Foundation\Model|array|null  $data  Request data
     */
    public function __construct(
        protected string $overtimeId,
        protected Model|array|null $data = null,
    ) {}

    protected function defaultBody(): array
    {
        return $this->data ? $this->data->toJsonApi() : [];
    }
}
