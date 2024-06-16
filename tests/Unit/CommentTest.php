<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_comment_can_be_added_to_a_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $this->actingAs($user)
             ->post('/comment', [
                'post_id' => $post->id,
                'body' => 'This is a test comment.'
             ]);

        $this->assertDatabaseHas('comments', [
            'post_id' => $post->id,
            'user_id' => $user->id,
            'body' => 'This is a test comment.'
        ]);
    }

    public function test_body_is_required_to_add_a_comment()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $response = $this->actingAs($user)
                         ->post('comment', [
                            'post_id' => $post->id,
                         ]);

        $response->assertSessionHasErrors('body');
    }

    public function test_post_id_is_required_to_add_a_comment()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $response = $this->actingAs($user)
                         ->post('comment', [
                            'body' => 'This is a test comment.'
                         ]);

        $response->assertSessionHasErrors('post_id');
    }

    public function test_only_authenticated_users_can_add_comments()
    {
        $post = User::factory()->create();
        $post = Post::factory()->create();

        $response = $this->post('/comment', [
            'body' => 'Test comment',
        ]);

        $response->assertRedirect('/login');
    }

    public function test_a_comment_can_be_deleted()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        $comment = Comment::factory()->create(['user_id' => $user->id, 'post_id' => $post->id]);

        $this->actingAs($user);

        $response = $this->delete("/comment/{$comment->id}");

        $response->assertStatus(302);
        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id
        ]);
    }
}
