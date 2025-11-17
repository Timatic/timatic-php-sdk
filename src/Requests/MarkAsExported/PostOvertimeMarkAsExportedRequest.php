<?php

namespace Timatic\SDK\Requests\MarkAsExported;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Timatic\SDK\Foundation\Model;

/**
 * postOvertimeMarkAsExported
 */
class PostOvertimeMarkAsExportedRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return "/overtimes/{$this->overtime}/mark-as-exported";
    }

    public function __construct(
        protected string $overtime,
        protected Model|array|null $data,
    ) {}

    protected function defaultBody(): array
    {
        return $this->data ? $this->data->toJsonApi() : [];
    }
}
