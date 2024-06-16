<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_post_can_be_created()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
             ->post('/post', [
                 'title' => 'Test Post',
                 'body' => 'This is a test post body.',
             ]);

        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post',
            'body' => 'This is a test post body.',
            'user_id' => $user->id
        ]);
    }

    public function test_title_and_body_are_required_to_create_a_post()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                        ->post('/post', []);

        $response->assertSessionHasErrors(['title', 'body']);
    }

    public function test_user_is_redirected_to_correct_page_after_creating_post()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                         ->post('/post', [
                             'title' => 'Test Post',
                             'body' => 'Test body',
                         ]);

        $response->assertRedirect(route('home'));
    }

    public function test_a_post_can_be_updated()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $response = $this->put("/post/{$post->id}", [
            'title' => 'Updated Post Title',
            'body' => 'Updated post body.'
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Post Title',
            'body' => 'Updated post body.'
        ]);
    }


    public function test_a_post_can_be_deleted()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $response = $this->delete("/post/{$post->id}");

        $response->assertStatus(302);
        $this->assertDatabaseMissing('posts', [
            'id' => $post->id
        ]);
    }
}
