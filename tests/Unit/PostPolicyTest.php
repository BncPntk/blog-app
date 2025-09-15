<?php

    namespace Tests\Unit;

    use App\Models\Post;
    use App\Models\User;
    use App\Policies\PostPolicy;
    use Tests\TestCase;

    class PostPolicyTest extends TestCase
    {
        public function test_owner_can_update_and_delete(): void
        {
            $policy = new PostPolicy();
            $user = new User(); $user->id = 1;
            $post = new Post(); $post->user_id = 1;

            $this->assertTrue($policy->update($user, $post));
            $this->assertTrue($policy->delete($user, $post));
        }

        public function test_non_owner_cannot_update_or_delete(): void
        {
            $policy = new PostPolicy();
            $user = new User(); $user->id = 2;
            $post = new Post(); $post->user_id = 1;

            $this->assertFalse($policy->update($user, $post));
            $this->assertFalse($policy->delete($user, $post));
        }
    }
