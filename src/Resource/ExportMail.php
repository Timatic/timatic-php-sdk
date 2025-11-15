<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\ExportMail\GetBudgetsExportMails;

class ExportMail extends BaseResource
{
	public function getBudgetsExportMails(): Response
	{
		return $this->connector->send(new GetBudgetsExportMails());
	}
}
