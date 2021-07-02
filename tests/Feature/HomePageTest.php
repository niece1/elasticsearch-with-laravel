<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Category::factory()->create();
        User::factory()->create();
    }

    /** @test */
    public function all_users_can_see_index_page()
    {
        $this->get('/')
                ->assertStatus(200)
                ->assertSee('Last news');
    }

    /** @test */
    public function no_posts_when_database_empty()
    {
        $this->get('/')->assertSeeText('Temporarily unavailable');
    }

    /** @test */
    public function see_one_post_when_there_is_one_in_the_database()
    {
        Post::factory()->create([
            'title' => 'New title',
        ]);
        $this->get('/')->assertSeeText('New title');
        $this->assertDatabaseHas('posts', [
            'title' => 'New title'
        ]);
    }
}
