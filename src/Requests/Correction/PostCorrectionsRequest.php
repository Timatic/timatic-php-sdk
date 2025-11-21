<?php

namespace Timatic\SDK\Requests\Correction;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Timatic\SDK\Foundation\Model;

/**
 * postCorrections
 */
class PostCorrectionsRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/corrections';
    }

    /**
     * @param  null|Timatic\SDK\Foundation\Model|array|null  $data  Request data
     */
    public function __construct(
        protected Model|array|null $data = null,
    ) {}

    protected function defaultBody(): array
    {
        return $this->data ? $this->data->toJsonApi() : [];
    }
}
