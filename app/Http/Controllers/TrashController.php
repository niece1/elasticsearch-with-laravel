<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;

class TrashController extends Controller
{
    /**
     * Display a listing of the trashed posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = PostRepository::getAllTrashed();
        return view('dashboard.trash.index', compact('posts'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $id
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Image $image)
    {
        PostRepository::expunge($id, $photo);
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
        return redirect('dashboard/posts');
    }
}
