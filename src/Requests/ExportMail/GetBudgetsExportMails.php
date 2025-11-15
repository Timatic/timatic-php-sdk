<?php

namespace Timatic\SDK\Requests\ExportMail;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Timatic\SDK\Foundation\Model;

/**
 * getBudgetsExportMails
 */
class GetBudgetsExportMails extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/budgets/export-mail";
	}


	public function __construct()
	{
	}
}
