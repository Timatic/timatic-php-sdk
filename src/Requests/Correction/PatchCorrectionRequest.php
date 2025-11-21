<?php

namespace Timatic\SDK\Requests\Correction;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Timatic\SDK\Concerns\Model;

/**
 * patchCorrection
 */
class PatchCorrectionRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function resolveEndpoint(): string
    {
        return "/corrections/{$this->correctionId}";
    }

    /**
     * @param  null|Timatic\SDK\Concerns\Model|array|null  $data  Request data
     */
    public function __construct(
        protected string $correctionId,
        protected Model|array|null $data = null,
    ) {}

    protected function defaultBody(): array
    {
        return $this->data ? $this->data->toJsonApi() : [];
    }
}
