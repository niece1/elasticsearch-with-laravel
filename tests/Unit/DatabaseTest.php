<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DatabaseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function posts_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('posts', [
            'id', 'title', 'body', 'slug', 'published', 'time_to_read',
            'user_id', 'category_id', 'image_source'
        ]), 1);
    }

    /** @test */
    public function users_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('users', [
            'id', 'name', 'email', 'email_verified_at', 'password'
        ]), 1);
    }

    /** @test */
    public function categories_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('categories', [
            'id', 'title'
        ]), 1);
    }

    /** @test */
    public function images_table_has_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('images', [
            'id', 'imageable_type', 'imageable_id', 'path'
        ]), 1);
    }
}
