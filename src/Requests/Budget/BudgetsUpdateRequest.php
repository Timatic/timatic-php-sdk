<?php

namespace Timatic\Requests\Budget;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Timatic\Dto\Budget;
use Timatic\Dto\BudgetUpdateRequest;
use Timatic\Foundation\JsonApi\JsonApiSerializer;
use Timatic\Foundation\JsonApi\JsonApiTransformer;

/**
 * budgets.update
 */
class BudgetsUpdateRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function createDtoFromResponse(Response $response): mixed
    {
        return Budget::from(JsonApiTransformer::flatten(
            Budget::class,
            $response->json('data') ?? [],
            $response->json('included') ?? []
        ));
    }

    public function resolveEndpoint(): string
    {
        return "/budgets/{$this->budgetId}";
    }

    /**
     * @param  int  $budgetId  The budget ID
     * @param  null|BudgetUpdateRequest  $data  Request data
     */
    public function __construct(
        protected int $budgetId,
        protected ?BudgetUpdateRequest $data = null,
    ) {}

    protected function defaultBody(): array
    {
        return $this->data ? ['data' => JsonApiSerializer::toJsonApi($this->data)] : [];
    }
}
