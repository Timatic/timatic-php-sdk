<?php

namespace Timatic\SDK\Dto;

use Timatic\SDK\Attributes\Property;
use Timatic\SDK\Concerns\Model;

class Overtime extends Model
{
    #[Property]
    public ?string $entryId;

    #[Property]
    public ?string $overtimeTypeId;

    #[Property]
    public ?string $startedAt;

    #[Property]
    public ?string $endedAt;

    #[Property]
    public ?string $percentages;

    #[Property]
    public ?string $approvedAt;

    #[Property]
    public ?string $approvedByUserId;

    #[Property]
    public ?string $exportedAt;

    #[Property]
    public ?string $createdAt;

    #[Property]
    public ?string $updatedAt;
}
