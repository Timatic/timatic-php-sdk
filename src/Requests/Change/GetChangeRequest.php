<?php

// auto-generated

namespace Timatic\Requests\Change;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * getChange
 */
class GetChangeRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/changes/{$this->changeId}";
    }

    public function __construct(
        protected string $changeId,
    ) {}
}
