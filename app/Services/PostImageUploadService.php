<?php

namespace App\Services;

use App\Models\Post;

/**
 * Save file to \storage\app\public\photos
 *
 * @author Volodymyr Zhonchuk
 */
final class PostImageUploadService extends ImageUploadService
{
    /*
     * Get post namespace
     *
     * @param  Illuminate\Http\Request $request
     * @return string
     */
    public function getModelClass()
    {
        return Post::class;
    }
}
