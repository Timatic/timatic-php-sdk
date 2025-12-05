<?php

// auto-generated

namespace Timatic\Requests\MarkAsExported;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Timatic\Dto\MarkAsExported;
use Timatic\Hydration\Facades\Hydrator;
use Timatic\Hydration\Model;

/**
 * postOvertimeMarkAsExported
 */
class PostOvertimeMarkAsExportedRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected $model = MarkAsExported::class;

    protected Method $method = Method::POST;

    public function createDtoFromResponse(Response $response): mixed
    {
        return Hydrator::hydrate(
            $this->model,
            $response->json('data'),
            $response->json('included')
        );
    }

    public function resolveEndpoint(): string
    {
        return "/overtimes/{$this->overtimeId}/mark-as-exported";
    }

    /**
     * @param  null|\Timatic\Hydration\Model|array|null  $data  Request data
     */
    public function __construct(
        protected string $overtimeId,
        protected Model|array|null $data = null,
    ) {}

    protected function defaultBody(): array
    {
        return $this->data ? ['data' => $this->data->toJsonApi()] : [];
    }
}
