<?php

// auto-generated

namespace Timatic\Requests\ExportMail;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\Dto\ExportMail;
use Timatic\Hydration\Facades\Hydrator;

/**
 * getBudgetsExportMails
 */
class GetBudgetsExportMailsRequest extends Request implements Paginatable
{
    protected $model = ExportMail::class;

    protected Method $method = Method::GET;

    public function createDtoFromResponse(Response $response): mixed
    {
        return Hydrator::hydrateCollection(
            $this->model,
            $response->json('data'),
            $response->json('included')
        );
    }

    public function resolveEndpoint(): string
    {
        return '/budgets/export-mail';
    }

    public function __construct() {}
}
