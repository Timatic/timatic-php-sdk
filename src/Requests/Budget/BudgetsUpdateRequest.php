<?php

namespace Timatic\Requests\Budget;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Timatic\DataTransferObjects\Budget;
use Timatic\DataTransferObjects\UpdateBudget;
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
     * @param  null|UpdateBudget  $data  Request data
     */
    public function __construct(
        protected int $budgetId,
        protected ?UpdateBudget $data = null,
    ) {}

    protected function defaultBody(): array
    {
        return $this->data ? ['data' => JsonApiSerializer::toJsonApi($this->data)] : [];
    }
}
