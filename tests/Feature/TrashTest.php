<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;

class TrashTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Category::factory()->create();
        User::factory()->create();
    }

    /** @test */
    public function a_post_can_be_deleted()
    {
        $post = Post::factory()->create();
        $post->forceDelete('/admin/posts/' . $post->id);
        $this->assertDeleted($post);
    }

    /** @test */
    public function a_post_can_be_restored()
    {
        $post = Post::factory()->create();
        $this->delete('/admin/posts/' . $post->id);
        $this->assertCount(0, Post::all());
        $this->post('/admin/restore/' . $post->id);
        $this->assertCount(1, Post::all());
    }
}
