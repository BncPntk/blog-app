<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_can_view_index_and_show(): void
    {
        $post = Post::factory()->for(User::factory())->create();

        $this->get('/posts')->assertOk();
        $this->get("/posts/{$post->id}")->assertOk();
    }

    public function test_guests_cannot_view_create_page(): void
    {
        $this->get('/posts/create')->assertRedirect('/login');
    }

    public function test_authenticated_user_can_create_post(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/posts', ['title' => 'Hello', 'content' => 'World'])
            ->assertRedirect('/posts');

        $this->assertDatabaseHas('posts', [
            'title' => 'Hello',
            'user_id' => $user->id,
        ]);
    }

    public function test_non_owner_cannot_update_or_delete(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $post = Post::factory()->for($owner)->create();

        $this->actingAs($other)
            ->put("/posts/{$post->id}", ['title' => 'X', 'content' => 'Y'])
            ->assertForbidden();

        $this->actingAs($other)
            ->delete("/posts/{$post->id}")
            ->assertForbidden();
    }

    public function test_owner_can_update_and_delete(): void
    {
        $owner = User::factory()->create();
        $post = Post::factory()->for($owner)->create(['title' => 'Old', 'content' => 'C']);

        $this->actingAs($owner)
            ->put("/posts/{$post->id}", ['title' => 'New', 'content' => 'C'])
            ->assertRedirect("/posts/{$post->id}");

        $post->refresh();
        $this->assertSame('New', $post->title);

        $this->actingAs($owner)
            ->delete("/posts/{$post->id}")
            ->assertRedirect('/posts');

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
