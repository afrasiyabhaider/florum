<?php

use App\Models\Comment;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\put;

it('check user authentication', function () {
    $comment = Comment::factory()->create();
    put(route('comments.update', $comment), ['body' => 'This is new body'])
        ->assertRedirect(route('login'));
});

it('updates the comment', function () {
    $comment = Comment::factory()->create();
    $newBody = 'This is new body';
    actingAs($comment->user)
        ->put(route('comments.update', $comment), [
            'body' => $newBody
        ]);

    $this->assertDatabaseHas(Comment::class, [
        'id' => $comment->id,
        'body' => $newBody
    ]);
});


it('redirect to posts show page', function () {
    $comment = Comment::factory()->create();
    $newBody = 'This is new body';
    actingAs($comment->user)
        ->put(route('comments.update', $comment), [
            'body' => $newBody
        ])
        ->assertRedirect(route('posts.show', $comment->post_id));
});

it('redirect to correct page of comments', function () {
    $comment = Comment::factory()->create();
    $newBody = 'This is new body';
    actingAs($comment->user)
        ->put(route('comments.update', ['comment' => $comment, 'page' => 2]), [
            'body' => $newBody
        ])
        ->assertRedirect(route('posts.show', ['post' => $comment->post_id, 'page' => 2]));
});

it('can not update comment of another user', function () {
    $comment = Comment::factory()->create();
    $newBody = 'This is new body';
    actingAs(User::factory()->create())
        ->put(route('comments.update', $comment), [
            'body' => $newBody
        ])
        ->assertForbidden();
});

it('requires a valid body', function ($body) {
    $comment = Comment::factory()->create();
    actingAs(User::factory()->create())
        ->put(route('comments.update', $comment), [
            'body' => $body
        ])
        ->assertForbidden();
})
    ->with([
        1,
        1.5,
        str_repeat('a', 2501),
        true
    ]);
