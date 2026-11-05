<?php

namespace Timatic\Dto;

use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\CustomerRequestFactory;
use Timatic\Foundation\JsonApi\Attributes\JsonApiType;
use Timatic\Foundation\JsonApi\HasTestFactory;

/**
 * CustomerRequest
 *
 *
 * @method static \Timatic\Factories\CustomerRequestFactory testFactory()
 */
#[JsonApiType('customers')]
class CustomerRequest extends SpatieData
{
    /** @use HasTestFactory<CustomerRequestFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $externalId = null,
        public ?string $name = null,
        public ?bool $isOwnOrganization = null,
    ) {}
}
