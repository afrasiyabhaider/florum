<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;

it('requires authentication', function () {
    delete(route('comments.destroy', Comment::factory()->create()))
        ->assertRedirect('login');
});

it('can delete the comment', function () {
    $comment = Comment::factory()->create();
    actingAs($comment->user)->delete(route('comments.destroy', $comment));
    $this->assertModelMissing($comment);
});
it('redirects to the posts show page', function () {
    $comment = Comment::factory()->create();
    actingAs($comment->user)
        ->delete(route('comments.destroy', $comment))
        ->assertRedirect(route('posts.show', $comment->post_id));
});
it('prevent deleting comments of other users', function () {
    $comment = Comment::factory()->create();
    actingAs(User::factory()->create())
        ->delete(route('comments.destroy', $comment))
        ->assertForbidden();
});
it('can not delete comment after 1 hour', function () {
    $this->freezeTime();
    $comment = Comment::factory()->create();
    $this->travel(1)->hour();
    actingAs($comment->user)
        ->delete(route('comments.destroy', $comment))
        ->assertForbidden();
});
