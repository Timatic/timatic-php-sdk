<?php

// auto-generated

namespace Timatic\Requests\Budget;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Timatic\Dto\Budget;
use Timatic\Hydration\Facades\Hydrator;
use Timatic\Hydration\Model;

/**
 * postBudgets
 */
class PostBudgetsRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected $model = Budget::class;

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
        return '/budgets';
    }

    /**
     * @param  null|\Timatic\Hydration\Model|array|null  $data  Request data
     */
    public function __construct(
        protected Model|array|null $data = null,
    ) {}

    protected function defaultBody(): array
    {
        return $this->data ? ['data' => $this->data->toJsonApi()] : [];
    }
}
