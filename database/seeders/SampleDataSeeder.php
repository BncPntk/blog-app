<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::query()->firstOrCreate(
            ['email' => 'admin@admin.com'],
            ['name' => 'admin', 'password' => 'admin', 'role' => 'admin']
        );

        $users = User::factory()->count(3)->create();

        $users->each(function (User $u) {
            Post::factory()->count(3)->for($u)->create()->each(function (Post $post) use ($u) {
                Comment::factory()->count(2)->for($post)->for($u)->create();
                Comment::factory()->count(2)->for($post)->create(['user_id' => null]);
            });
        });
    }
}
