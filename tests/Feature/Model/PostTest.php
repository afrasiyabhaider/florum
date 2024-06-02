<?php

use App\Models\Post;
use Illuminate\Support\Str;

it('uses title case for post title', function () {
    $post = Post::factory()->create(['title' => 'Hello, How are you?']);

    expect($post->title)->toBe('Hello, How Are You?');
});
it('can generate a route to the show page', function () {
    $post = Post::factory()->create();

    expect($post->showRoute())->toBe(route('posts.show', [$post, Str::slug($post->title)]));
});

it('can generate additional query parameters on the show route', function () {
    $post = Post::factory()->create();

    expect($post->showRoute(['page' => 2]))
        ->toBe(route('posts.show', [$post, Str::slug($post->title), 'page' => 2]));
});
