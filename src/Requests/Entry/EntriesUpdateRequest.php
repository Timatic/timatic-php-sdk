<?php

// auto-generated

namespace Timatic\Requests\Entry;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Timatic\Dto\Entry;
use Timatic\Hydration\Facades\Hydrator;
use Timatic\Hydration\Model;

/**
 * entries.update
 */
class EntriesUpdateRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected $model = Entry::class;

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
        return "/entries/{$this->entryId}";
    }

    /**
     * @param  int  $entryId  The entry ID
     * @param  null|\Timatic\Hydration\Model|array|null  $data  Request data
     */
    public function __construct(
        protected int $entryId,
        protected Model|array|null $data = null,
    ) {}

    protected function defaultBody(): array
    {
        return $this->data ? ['data' => $this->data->toJsonApi()] : [];
    }
}
