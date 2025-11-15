<?php

namespace Timatic\SDK\Dto;

use Timatic\SDK\Attributes\DateTime;
use Timatic\SDK\Attributes\Property;
use Timatic\SDK\Foundation\Model;

class BudgetTimeSpentTotal extends Model
{
	#[Property]
	#[DateTime]
	public null|\Carbon\Carbon $start;

	#[Property]
	#[DateTime]
	public null|\Carbon\Carbon $end;

	#[Property]
	public ?int $remainingMinutes;

	#[Property]
	public ?string $periodUnit;

	#[Property]
	public ?int $periodValue;
}
