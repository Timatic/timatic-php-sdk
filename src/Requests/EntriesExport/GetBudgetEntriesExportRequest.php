<?php

namespace Timatic\SDK\Requests\EntriesExport;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Timatic\SDK\Dto\EntriesExport;
use Timatic\SDK\Hydration\Facades\Hydrator;

/**
 * getBudgetEntriesExport
 */
class GetBudgetEntriesExportRequest extends Request
{
    protected $model = EntriesExport::class;

    protected Method $method = Method::GET;

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
        return "/budgets/{$this->budgetId}/entries-export";
    }

    public function __construct(
        protected string $budgetId,
        protected ?string $include = null,
    ) {}

    protected function defaultQuery(): array
    {
        return array_filter(['include' => $this->include]);
    }
}
