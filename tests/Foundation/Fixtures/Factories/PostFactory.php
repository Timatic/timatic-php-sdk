<?php

declare(strict_types=1);

namespace Timatic\Tests\Foundation\Fixtures\Factories;

use Carbon\Carbon;
use Timatic\Foundation\Factories\Factory;
use Timatic\Tests\Foundation\Fixtures\DataTransferObjects\Post;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    protected function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'publishedAt' => Carbon::now()->subDays($this->faker->numberBetween(0, 365)),
        ];
    }

    protected function modelClass(): string
    {
        return Post::class;
    }
}
