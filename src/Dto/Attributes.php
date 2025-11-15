<?php

namespace Timatic\SDK\Dto;

use Spatie\LaravelData\Data as SpatieData;

class Attributes extends SpatieData
{
	public function __construct(
		public ?string $userId = null,
		public ?string $date = null,
		public ?string $progress = null,
	) {
	}
}
