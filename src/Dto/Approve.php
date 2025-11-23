<?php

namespace Timatic\SDK\Dto;

use Timatic\SDK\Hydration\Attributes\DateTime;
use Timatic\SDK\Hydration\Attributes\Property;
use Timatic\SDK\Hydration\Model;

class Approve extends Model
{
    #[Property]
    public ?string $entryId;

    #[Property]
    public ?string $overtimeTypeId;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $startedAt;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $endedAt;

    #[Property]
    public ?string $percentages;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $approvedAt;

    #[Property]
    public ?string $approvedByUserId;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $exportedAt;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $createdAt;

    #[Property]
    #[DateTime]
    public ?\Carbon\Carbon $updatedAt;
}
