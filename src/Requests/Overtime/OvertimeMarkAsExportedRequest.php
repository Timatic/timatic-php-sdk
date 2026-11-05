<?php

namespace Timatic\Requests\Overtime;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Spatie\LaravelData\Data;
use Timatic\Dto\Overtime;
use Timatic\Foundation\JsonApi\JsonApiSerializer;
use Timatic\Foundation\JsonApi\JsonApiTransformer;

/**
 * overtime.mark-as-exported
 */
class OvertimeMarkAsExportedRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function createDtoFromResponse(Response $response): mixed
    {
        return Overtime::from(JsonApiTransformer::flatten(
            Overtime::class,
            $response->json('data') ?? [],
            $response->json('included') ?? []
        ));
    }

    public function resolveEndpoint(): string
    {
        return "/overtimes/{$this->overtimeId}/mark-as-exported";
    }

    /**
     * @param  int  $overtimeId  The overtime ID
     * @param  null|Data|array|null  $data  Request data
     */
    public function __construct(
        protected int $overtimeId,
        protected Data|array|null $data = null,
    ) {}

    protected function defaultBody(): array
    {
        return $this->data ? ['data' => JsonApiSerializer::toJsonApi($this->data)] : [];
    }
}
