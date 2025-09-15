<?php

    namespace Tests\Feature;

    use App\Models\Comment;
    use App\Models\Post;
    use App\Models\User;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Tests\TestCase;

    class AdminAccessTest extends TestCase
    {
        use RefreshDatabase;

        public function test_admin_can_delete_any_post(): void
        {
            $admin = User::factory()->create(['role' => 'admin']);
            $someone = User::factory()->create();
            $post = Post::factory()->for($someone)->create();

            $this->actingAs($admin)
                ->delete("/posts/{$post->id}")
                ->assertRedirect('/posts');

            $this->assertDatabaseMissing('posts', ['id' => $post->id]);
        }

        public function test_admin_can_delete_any_comment(): void
        {
            $admin = User::factory()->create(['role' => 'admin']);
            $postOwner = User::factory()->create();
            $post = Post::factory()->for($postOwner)->create();
            $comment = Comment::factory()->for($post)->create(['user_id' => null]);

            $this->actingAs($admin)
                ->delete("/comments/{$comment->id}")
                ->assertRedirect();

            $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
        }
    }
