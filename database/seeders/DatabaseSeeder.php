<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory(10)->create();
        $post = Post::factory(200)->recycle($user)->create();
        $comments = Comment::factory(100)->recycle($user)->recycle($post)->create();

        $afrasiyab = User::factory()
                    ->has(Post::factory(45))
                    ->has(Comment::factory(120)->recycle($post))
                    ->create([
                        'name' => 'Afrasiyab Haider',
                        'email' => 'test@example.com'
                    ]);
    }
}
