@extends('layouts.admin')

@section('title', 'Edit: ' . $post->title)

@section('content')

<!-- Title jumbotron -->
<section class="title-jumbotron">
    <div class="parallax-text">
        <h1>Edit Post</h1>
    </div>
</section>
<!-- /.Title jumbotron -->

<!-- Dashboard -->
<section class="dashboard">
    <div class="dashboard-wrapper">
        <a href="/admin/posts" class="back">Back</a>
        <div class="well">
            <div class="well-title">
                <h5>Edit Post</h5>
            </div>
            <div class="well-content">
                <form action="{{ route('posts.update', $post->id) }}" method="POST" class="create-update" enctype="multipart/form-data">
                    @method('PATCH')
                    @include('/admin/includes.form')
                    <button type="submit" class="button">Save</button>
                    @csrf
                </form>
            </div>
        </div>
    </div>
</section>
<!-- /.Dashboard -->

@endsection
