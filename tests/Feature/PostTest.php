<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Category::factory()->create();
        User::factory()->create();
    }

    /** @test */
    public function a_post_can_be_added_to_the_table_through_the_form()
    {
        $this->post('/admin/posts', $this->createPostAttributes())
                ->assertRedirect('/admin/posts');
        $this->assertCount(1, Post::all());
    }

    /** @test */
    public function validation_title_is_required()
    {
        $this->post('/admin/posts', array_merge($this->createPostAttributes(), [
            'title' => '',
        ]))
                ->assertSessionHasErrors('title');
    }

    /** @test */
    public function store_post_validation_fails()
    {
        $this->post('/admin/posts', array_merge($this->createPostAttributes(), [
            'title' => 'N',
            'body' => '',
        ]))
                ->assertStatus(302)
                ->assertSessionHas('errors');
        $messages = session('errors')->getMessages();
        $this->assertEquals($messages['title'][0], 'The title must be at least 2 characters.');
        $this->assertEquals($messages['body'][0], 'The body field is required.');
    }

    /** @test */
    public function validation_title_is_at_least_two_characters()
    {
        $this->post('/admin/posts', array_merge($this->createPostAttributes(), [
            'title' => 'A',
        ]))
                ->assertSessionHasErrors('title');
        $this->assertCount(0, Post::all());
    }

    /** @test */
    public function validation_body_is_required()
    {
        $this->post('/admin/posts', array_merge($this->createPostAttributes(), [
            'body' => '',
        ]))
                ->assertSessionHasErrors('body');
        $this->assertCount(0, Post::all());
    }

    /** @test */
    public function validation_time_to_read_is_required()
    {
        $this->post('/admin/posts', array_merge($this->createPostAttributes(), [
            'time_to_read' => '',
        ]))
                ->assertSessionHasErrors('time_to_read');
        $this->assertCount(0, Post::all());
    }

    /** @test */
    public function validation_category_id_is_required()
    {
        $this->post('/admin/posts', array_merge($this->createPostAttributes(), [
            'category_id' => '',
        ]))
                ->assertSessionHasErrors('category_id');
        $this->assertCount(0, Post::all());
    }

    /** @test */
    public function a_post_can_be_updated()
    {
        $post = Post::factory()->create();
        $this->patch('/admin/posts/' . $post->id, $this->createPostAttributes())
                ->assertRedirect('/admin/posts/');
        $this->assertEquals('New Title', Post::first()->title);
        $this->assertEquals('New body', Post::first()->body);
        $this->assertDatabaseMissing('posts', $post->toArray());
        $this->assertDatabaseHas('posts', ['title' => 'New Title']);
    }

    /** @test */
    public function a_post_can_be_trashed()
    {
        $post = Post::factory()->create();
        $this->assertCount(1, Post::all());
        $this->delete('/admin/posts/' . $post->id);
        $this->assertCount(0, Post::all());
        $this->assertSoftDeleted($post);
    }

    /**
     * Creates attributes for Post entity
     *
     * @return array
     */
    private function createPostAttributes()
    {
        return [
            'title' => 'New Title',
            'body' => 'New body',
            'time_to_read' => 1,
            'category_id' => 1,
        ];
    }
}
