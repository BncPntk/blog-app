<?php

    namespace Tests\Unit;

    use App\Models\Comment;
    use App\Models\Post;
    use App\Models\User;
    use App\Policies\CommentPolicy;
    use Tests\TestCase;

    class CommentPolicyTest extends TestCase
    {
        public function test_author_or_post_owner_can_delete(): void
        {
            $policy = new CommentPolicy();

            $post = new Post(); $post->user_id = 2;

            $comment = new Comment(); $comment->user_id = 1;
            $comment->setRelation('post', $post);

            $author = new User(); $author->id = 1;
            $postOwner = new User(); $postOwner->id = 2;
            $other = new User(); $other->id = 3;

            $this->assertTrue($policy->delete($author, $comment));
            $this->assertTrue($policy->delete($postOwner, $comment));
            $this->assertFalse($policy->delete($other, $comment));
        }
    }
