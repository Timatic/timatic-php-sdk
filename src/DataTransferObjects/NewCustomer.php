<?php

namespace Timatic\DataTransferObjects;

use Spatie\LaravelData\Data as SpatieData;
use Timatic\Factories\NewCustomerFactory;
use Timatic\Foundation\JsonApi\Attributes\JsonApiType;
use Timatic\Foundation\JsonApi\HasTestFactory;

/**
 * CustomerRequest
 *
 *
 * @method static \Timatic\Factories\NewCustomerFactory testFactory()
 */
#[JsonApiType('customers')]
class NewCustomer extends SpatieData
{
    /** @use HasTestFactory<NewCustomerFactory> */
    use HasTestFactory;

    public function __construct(
        public ?string $externalId = null,
        public ?string $name = null,
        public ?bool $isOwnOrganization = null,
    ) {}
}
