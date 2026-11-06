<?php

use Timatic\Foundation\Filtering\Operator;
use Timatic\Tests\Foundation\Fixtures\Requests\ListPostsRequest;

test('it adds filters to the query', function () {
    // Given
    $request = new ListPostsRequest;

    // When
    $request
        ->filter('authorId', 'author-1')
        ->filter('publishedAt', '2026-01-01', Operator::GreaterThanOrEquals);

    // Then
    expect($request->query()->all())->toBe([
        'filter[authorId]' => 'author-1',
        'filter[publishedAt][gte]' => '2026-01-01',
    ]);
});
