<?php

namespace Timatic\SDK\Requests\Budget;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Timatic\SDK\Dto\Budget;
use Timatic\SDK\Hydration\Facades\Hydrator;
use Timatic\SDK\Hydration\Model;

/**
 * patchBudget
 */
class PatchBudgetRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected $model = Budget::class;

    protected Method $method = Method::PATCH;

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
        return "/budgets/{$this->budgetId}";
    }

    /**
     * @param  null|\Timatic\SDK\Hydration\Model|array|null  $data  Request data
     */
    public function __construct(
        protected string $budgetId,
        protected Model|array|null $data = null,
    ) {}

    protected function defaultBody(): array
    {
        return $this->data ? $this->data->toJsonApi() : [];
    }
}
