<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Image;

class TrashController extends Controller
{
    /**
     * Display a listing of the trashed posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with(['image', 'category'])
                ->onlyTrashed()
                ->get();
        return view('admin.trash', compact('posts'));
    }

    /**
     * Remove the specified resource from database.
     *
     * @param  \App\Post  $id
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Image $image)
    {
        $post = Post::withTrashed()
                ->where('id', $id)
                ->first();
        if ($post->image) {
            $image->deleteImage($post->image->id);
        }
        $post->forceDelete();
        return redirect()->back();
    }

    /**
     * Return post from trash.
     *
     * @param  \App\Post  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $post = Post::withTrashed()
                ->where('id', $id)
                ->first();
        $post->restore();
        return redirect('admin/posts');
    }
}
