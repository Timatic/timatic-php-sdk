<?php

namespace Timatic\SDK\Dto;

use Timatic\SDK\Attributes\DateTime;
use Timatic\SDK\Attributes\Property;
use Timatic\SDK\Foundation\Model;

class TimeSpentTotal extends Model
{
	#[Property]
	#[DateTime]
	public null|\Carbon\Carbon $start;

	#[Property]
	#[DateTime]
	public null|\Carbon\Carbon $end;

	#[Property]
	public ?int $internalMinutes;

	#[Property]
	public ?int $billableMinutes;

	#[Property]
	public ?string $periodUnit;

	#[Property]
	public ?int $periodValue;
}
