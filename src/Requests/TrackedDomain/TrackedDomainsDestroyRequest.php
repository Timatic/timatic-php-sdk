<?php

namespace Timatic\Requests\TrackedDomain;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * tracked-domains.destroy
 */
class TrackedDomainsDestroyRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return "/tracked-domains/{$this->trackedDomainId}";
    }

    /**
     * @param  mixed  $trackedDomainId  The tracked domain ID
     */
    public function __construct(
        protected mixed $trackedDomainId,
    ) {}
}
