@extends('layouts.admin')

@section('title', 'Posts')

@section('content')

<!-- Title jumbotron -->
<section class="title-jumbotron">
    <div class="parallax-text">
        <h1>Posts</h1>
    </div>
</section>
<!-- /.Title jumbotron -->

<!-- Admin -->
<section class="dashboard">
    <div class="dashboard-wrapper">
        <a href="/admin/posts/create" class="button">Add Post</a>
        <div class="well">
            <div class="well-title">
                <h5>Post List</h5>
            </div>
            <div class="well-content">
                <!-- Table -->
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th></th>
                    </tr>
                    @foreach ($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>
                            @if ($post->image)
                            <img src="{{ asset('storage/' . $post->image->path) }}" height="60" width="90" alt="Image">
                            @endif
                        </td>
                        <td>
                            <a href="#">{{ $post->title }}</a>
                        </td>
                        <td>
                            @if ($post->category)
                            {{ $post->category>title }}
                            @endif
                        </td>
                        <td>
                            <a href="/admin/posts/{{ $post->id }}/edit" class="action-button-green">Edit</a>
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="action-button-red">Delete</button>
                            </form>
                        </td>
                    </tr>				
                    @endforeach
                </table>
                <!-- /.Table -->
            </div>
        </div>
    </div>
</section>
<!-- /.Admin -->

<!-- Pagination section -->
<section class="news-pagination">
    <div class="news-pagination-wrapper">
        {{ $posts->links('vendor.pagination.default') }}
    </div>
</section>
<!-- /.Pagination section -->

@endsection
