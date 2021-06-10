<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Services\SlugService;
use App\Services\PostPhotoUploadService;

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(
            StorePostRequest $request,
            SlugService $slugService,
            PostPhotoUploadService $postPhotoUploadService
    ) {
        $post = Post::create($request->all());
        $slugService->generateSlug($request, $post);
        $postPhotoUploadService->store($request, $post);
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
        $posts = Post::all();
        return view('admin.edit', compact('post', 'posts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $post
     * @return \Illuminate\Http\Response
     */
    public function update(
            UpdatePostRequest $request,
            Post $post,
            SlugService $slugService,
            PostPhotoUploadService $postPhotoUploadService
    ) {
        $post->update($request->all());
        $this->storeImage($post);
        return redirect('admin/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $post
     * @return \Illuminate\Http\Response
     */
    public function destryoy(Post $post)
    {
        $post->delete();
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
        PostRepository::removeToTrash($post);

        return redirect('admin/posts');
    }
}
