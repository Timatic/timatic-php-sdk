<?php

namespace Timatic\Dto;

use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\UpdateCustomerFactory;
use Timatic\Foundation\JsonApi\Attributes\JsonApiType;
use Timatic\Foundation\JsonApi\HasTestFactory;

/**
 * CustomerRequest
 *
 *
 * @method static \Timatic\Factories\UpdateCustomerFactory testFactory()
 */
#[JsonApiType('customers')]
class UpdateCustomer extends SpatieData
{
    /** @use HasTestFactory<UpdateCustomerFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $externalId = null,
        public ?string $name = null,
        public ?bool $isOwnOrganization = null,
    ) {}
}
