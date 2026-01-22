<?php

namespace Timatic\Requests\Overtime;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Timatic\Dto\Overtime;
use Timatic\Foundation\Hydration\Facades\Hydrator;
use Timatic\Foundation\Hydration\Model;

/**
 * overtime.mark-as-exported
 */
class OvertimeMarkAsExportedRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected $model = Overtime::class;

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
     * @param  int  $overtimeId  The overtime ID
     * @param  null|\Timatic\Foundation\Hydration\Model|array|null  $data  Request data
     */
    public function __construct(
        protected int $overtimeId,
        protected Model|array|null $data = null,
    ) {}

    protected function defaultBody(): array
    {
        return $this->data ? ['data' => $this->data->toJsonApi()] : [];
    }
}
