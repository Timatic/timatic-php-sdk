<?php

namespace Timatic\SDK\Dto;

use Timatic\SDK\Attributes\DateTime;
use Timatic\SDK\Attributes\Property;
use Timatic\SDK\Foundation\Model;

class Team extends Model
{
	#[Property]
	public ?string $externalId;

	#[Property]
	public ?string $name;

	#[Property]
	#[DateTime]
	public null|\Carbon\Carbon $createdAt;

	#[Property]
	#[DateTime]
	public null|\Carbon\Carbon $updatedAt;
}
