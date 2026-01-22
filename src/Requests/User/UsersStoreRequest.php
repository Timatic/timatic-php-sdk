<?php

namespace Timatic\Requests\User;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Timatic\Dto\User;
use Timatic\Foundation\Hydration\Facades\Hydrator;
use Timatic\Foundation\Hydration\Model;

/**
 * users.store
 */
class UsersStoreRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected $model = User::class;

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
        return '/users';
    }

    /**
     * @param  null|\Timatic\Foundation\Hydration\Model|array|null  $data  Request data
     */
    public function __construct(
        protected Model|array|null $data = null,
    ) {}

    protected function defaultBody(): array
    {
        return $this->data ? ['data' => $this->data->toJsonApi()] : [];
    }
}
