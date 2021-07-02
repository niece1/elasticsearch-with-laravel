<?php

namespace App\Traits;

trait DeleteImage
{
    use BaseImageUpload;

    /**
     * Delete image from database.
     *
     * @param int $id
     * @return void
     */
    public function deleteImage($id)
    {
        $image = $this->getImage($id);
        $this->deleteImageFromStorageFolder($image);
        $image->delete($id);
    }
}
