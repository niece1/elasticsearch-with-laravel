<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Services\SlugService;
use App\Services\PostImageUploadService;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with(['user'])
                ->orderBy('id', 'desc')
                ->paginate(15);
        return view('admin.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $post = new Post();
        $categories = Category::all();
        return view('admin.create', compact('post', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @param  \App\Services\SlugService $slugService
     * @param  \App\Services\PostImageUploadService $postImageUploadService
     * @return \Illuminate\Http\Response
     */
    public function store(
            StorePostRequest $request,
            SlugService $slugService,
            PostImageUploadService $postImageUploadService
    ) {
        $post = Post::create($request->all());
        $slugService->generateSlug($request, $post);
        $postImageUploadService->store($request, $post);
        return redirect('admin/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('admin.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  int  $post
     * @param  \App\Services\SlugService $slugService
     * @param  \App\Services\PostImageUploadService $postImageUploadService
     * @return \Illuminate\Http\Response
     */
    public function update(
            UpdatePostRequest $request,
            Post $post,
            SlugService $slugService,
            PostImageUploadService $postImageUploadService
    ) {
        $post->update($request->all());
        $slugService->generateSlug($request, $post);
        $postImageUploadService->store($request, $post);
        return redirect('admin/posts');
    }
    
    /**
     * Remove the specified resource to trash.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect('admin/posts');
    }
}
