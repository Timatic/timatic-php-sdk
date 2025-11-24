<?php

namespace Timatic\SDK\Requests\Entry;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Timatic\SDK\Dto\Entry;
use Timatic\SDK\Hydration\Facades\Hydrator;
use Timatic\SDK\Hydration\Model;

/**
 * postEntries
 */
class PostEntriesRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected $model = Entry::class;

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
        return '/entries';
    }

    /**
     * @param  null|\Timatic\SDK\Hydration\Model|array|null  $data  Request data
     */
    public function __construct(
        protected Model|array|null $data = null,
    ) {}

    protected function defaultBody(): array
    {
        return $this->data ? $this->data->toJsonApi() : [];
    }
}
