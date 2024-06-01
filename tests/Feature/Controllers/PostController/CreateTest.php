<?php

use App\Models\Post;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('requires authentication', function () {
    get(route('posts.create'))
        ->assertRedirect('login');
});
it('renders the correct component', function () {
    $user = User::factory()->create();
    actingAs($user)
        ->get(route('posts.create'))
        ->assertComponent('Posts/Create');
});
