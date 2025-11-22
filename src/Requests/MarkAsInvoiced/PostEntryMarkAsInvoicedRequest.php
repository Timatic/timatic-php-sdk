<?php

namespace Timatic\SDK\Requests\MarkAsInvoiced;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Timatic\SDK\Concerns\Model;
use Timatic\SDK\Dto\MarkAsInvoiced;
use Timatic\SDK\Hydration\Facades\Hydrator;

/**
 * postEntryMarkAsInvoiced
 */
class PostEntryMarkAsInvoicedRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected $model = MarkAsInvoiced::class;

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
        return "/entries/{$this->entryId}/mark-as-invoiced";
    }

    /**
     * @param  null|Timatic\SDK\Concerns\Model|array|null  $data  Request data
     */
    public function __construct(
        protected string $entryId,
        protected Model|array|null $data = null,
    ) {}

    protected function defaultBody(): array
    {
        return $this->data ? $this->data->toJsonApi() : [];
    }
}
