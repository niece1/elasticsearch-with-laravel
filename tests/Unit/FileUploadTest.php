<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\Category;
use App\Models\Post;
use App\Models\Image;
use App\Models\User;
use Tests\TestCase;

class FileUploadTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        User::factory()->create();
        Category::factory()->create();
        Storage::fake('public');
    }

    /** @test */
    public function post_image_uploaded_successfully()
    {
        $file = UploadedFile::fake()->image('logo.png');
        $this->createPost($file);
        $this->assertDirectoryExists('public');
        $this->assertDirectoryIsReadable('public');
        $this->assertDirectoryIsWritable('public');
        Storage::disk('public')->assertExists('images/' . $file->hashName());
        $this->assertFileExists('public');
        $this->assertFileIsReadable('public');
        $this->assertFileIsWritable('public');
    }

    /** @test */
    public function post_image_upload_fails_if_image_size_more_than_5mb()
    {
        $file = UploadedFile::fake()->image('logo.png')->size(6000);
        $this->createPost($file);
        Storage::disk('public')->assertMissing('posts/' . $file->hashName());
        $messages = session('errors')->getMessages();
        $this->assertEquals($messages['image'][0], 'The image must not be greater than 5000 kilobytes.');
    }

    /** @test */
    public function post_image_upload_fails_if_file_is_not_image()
    {
        $file = UploadedFile::fake()->image('logo.pdf');
        $this->createPost($file);
        Storage::disk('public')->assertMissing('posts/' . $file->hashName());
        $messages = session('errors')->getMessages();
        $this->assertEquals($messages['image'][0], 'The image must be an image.');
    }

    /** @test */
    public function a_post_morphs_one_image()
    {
        $image = UploadedFile::fake()->image('logo.png');
        $this->createPost($image);
        $post = Post::first();
        $this->assertInstanceOf(Image::class, $post->image);
        $this->assertTrue($post->image()->exists());
    }

    /**
     * Creates post with uploaded file
     *
     * @param type $file
     * @return array
     */
    private function createPost($file)
    {
        return $this->post('/admin/posts', [
            'title' => 'New Title',
            'body' => 'New body',
            'time_to_read' => 1,
            'category_id' => 1,
            'image' => $file,
        ]);
    }
}
