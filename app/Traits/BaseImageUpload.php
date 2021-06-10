<?php

namespace App\Traits;

use App\Image;
use Illuminate\Support\Facades\Storage;

trait BaseImageUpload
{
    /**
     * Get image of specified resource.
     *
     * @param int $id
     * @return \App\Image
     */
    private function getImage($id)
    {
        return Image::find($id);
    }

    /**
     * Delete image from folder.
     *
     * @param \App\Image $image
     * @return bool
     */
    private function deleteImageFromStorageFolder(Image $image)
    {
        return Storage::disk('public')->delete($image->original_path);
    }
}
