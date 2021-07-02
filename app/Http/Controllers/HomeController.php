<?php

namespace App\Http\Controllers;

use App\Models\Post;

class HomeController extends Controller
{
    /**
     * Display post listing and featured post.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with(['image', 'category', 'user'])
                ->where('published', 1)
                ->orderBy('id', 'desc')
                ->paginate(12);
        return view('frontend.index', compact('posts'));
    }
}
