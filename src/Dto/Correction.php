<?php

namespace Timatic\SDK\Dto;

use Timatic\SDK\Attributes\DateTime;
use Timatic\SDK\Attributes\Property;
use Timatic\SDK\Foundation\Model;

class Correction extends Model
{
	#[Property]
	#[DateTime]
	public null|\Carbon\Carbon $createdAt;

	#[Property]
	#[DateTime]
	public null|\Carbon\Carbon $updatedAt;
}
