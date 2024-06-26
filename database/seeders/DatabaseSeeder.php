<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(TopicSeeder::class);
        $topics = Topic::all();

        $user = User::factory(10)->create();
        $post = Post::factory(200)
            ->withFixture()
            ->has(Comment::factory(15)->recycle($user))
            ->recycle([$user, $topics])
            ->create();

        $afrasiyab = User::factory()
            ->has(Post::factory(45)->recycle($topics)->withFixture())
            ->has(Comment::factory(120)->recycle($post))
            ->create([
                'name' => 'Afrasiyab Haider',
                'email' => 'test@example.com'
            ]);
    }
}
