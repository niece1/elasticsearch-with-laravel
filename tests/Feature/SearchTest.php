<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Category;
use App\Models\User;
use App\Models\Post;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Category::factory()->create();
        User::factory()->create();
    }

    /** @test */
    public function search_on_title_keyword_is_successfull()
    {
        Post::factory()->create([
            'title' => 'Toyota',
            'body' => 'Toyota is a new market winner.',
        ]);
        $this->get('/search', [
            'keyword' => 'Toyota',
        ])
                ->assertStatus(200)
                ->assertSee('Toyota');
    }

    /** @test */
    public function search_on_body_keyword_is_successfull()
    {
        Post::factory()->create([
            'title' => 'BMW',
            'body' => 'Suzuki is a new market winner.',
        ]);
        $this->get('/search', [
            'keyword' => 'Suzuki',
        ])
                ->assertStatus(200)
                ->assertSee('BMW');
    }

    /** @test */
    public function search_non_existed_keyword_wont_gain_results()
    {
        Post::factory()->create([
            'title' => 'BMW',
            'body' => 'Suzuki is a new market winner.',
        ]);
        $this->get('/search', [
            'keyword' => 'Toyota',
        ])
                ->assertStatus(200)
                ->assertDontSee('Toyota');
    }
}
