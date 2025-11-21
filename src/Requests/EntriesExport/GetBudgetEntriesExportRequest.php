<?php

namespace Timatic\SDK\Requests\EntriesExport;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getBudgetEntriesExport
 */
class GetBudgetEntriesExportRequest extends Request
{
    protected Method $method = Method::GET;

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
