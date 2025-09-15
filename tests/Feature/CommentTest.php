<?php

    namespace Tests\Feature;

    use App\Models\Comment;
    use App\Models\Post;
    use App\Models\User;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Support\Str;
    use Tests\TestCase;

    class CommentTest extends TestCase
    {
        use RefreshDatabase;

        public function test_guest_can_comment(): void
        {
            $post = Post::factory()->for(User::factory())->create();

            $guestKey = (string) Str::uuid();

            $this->withSession(['guest_key' => $guestKey])
                ->post("/posts/{$post->id}/comments", ['comment' => 'hi'])
                ->assertRedirect("/posts/{$post->id}");

            $saved = Comment::where('post_id', $post->id)->latest()->first();
            $this->assertNotNull($saved);
            $this->assertSame('hi', $saved->comment);
            $this->assertSame($guestKey, $saved->guest_key);
        }

        public function test_guest_can_delete_only_own_comment_via_session_key(): void
        {
            $post = Post::factory()->for(User::factory())->create();
            $guestKey = (string) Str::uuid();

            $mine  = Comment::factory()->for($post)->create(['guest_key' => $guestKey]);
            $other = Comment::factory()->for($post)->create(['guest_key' => (string) Str::uuid()]);

            $this->withSession(['guest_key' => $guestKey])
                ->delete("/comments/{$mine->id}")
                ->assertRedirect();

            $this->assertDatabaseMissing('comments', ['id' => $mine->id]);

            $this->withSession(['guest_key' => $guestKey])
                ->delete("/comments/{$other->id}")
                ->assertForbidden();
        }
    }
