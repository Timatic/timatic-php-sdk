<?php

namespace Timatic\SDK\Requests\MarkAsExported;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Timatic\SDK\Concerns\Model;

/**
 * postOvertimeMarkAsExported
 */
class PostOvertimeMarkAsExportedRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return "/overtimes/{$this->overtimeId}/mark-as-exported";
    }

    /**
     * @param  null|Timatic\SDK\Concerns\Model|array|null  $data  Request data
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
