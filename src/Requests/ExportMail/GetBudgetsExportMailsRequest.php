<?php

namespace Timatic\SDK\Requests\ExportMail;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\Paginatable;

/**
 * getBudgetsExportMails
 */
class GetBudgetsExportMailsRequest extends Request implements Paginatable
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/budgets/export-mail';
    }

    public function __construct() {}
}
