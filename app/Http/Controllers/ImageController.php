<?php

namespace App\Http\Controllers;

use App\Models\Image;

class ImageController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function delete($id, Image $image)
    {
        $image->deleteImage($id);
        return redirect()->back();
    }
}
