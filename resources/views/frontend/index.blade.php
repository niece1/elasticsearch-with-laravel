@extends('layouts.frontend')

@section('title', 'Elastic main page')

@section('content')

<!-- Title jumbotron -->
<section class="title-jumbotron">
    <div class="parallax-text">
        <h1>News</h1>
    </div>
</section>
<!-- /.Title jumbotron -->

<!-- Posts section -->
<section class="news">
    <h1>Last news</h1>
    <div class="news-wrapper">
        @forelse ($posts as $post)
        <div class="item">
            @if ($post->image)
            <div class="image-holder">
                <a href="#">
                    <img src="{{ asset('storage/' . $post->image->path) }}" alt="Image">
                    <div class="image-overlay"></div>
                </a>
            </div>
            @endif
            <div class="item-content">
                <a href="#">
                    <h6>{{ $post->title }}</h6>
                </a>
                <p class="item-blog-text">
                    {{ $post->description }}{{ $post->three_dots }}
                </p>
                @if ($post->user)
                <p class="item-blog-author">
                    <i class="fas fa-user-edit"></i>
                    <a href="#">{{ $post->user->name }}</a>
                </p>
                @endif
                <p>
                    <i class="fas fa-clock"></i>
                    Time to read: {{ $post->time_to_read }} мин.
                </p>
                <p class="item-blog-comment">
                    Comments: 12
                </p>
                <p class="item-blog-date">{{ $post->date }}</p>                
                <div class="blog-line">
                </div>
                <div class="item-blog-bottom">
                    <a href="#" class="button">Read</a>
                    @if ($post->category)
                    <p>
                        <i class="fas fa-tags"></i>
                        <a href="#">{{ $post->category->title }}</a>
                    </p>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <h1>Temporarily unavailable</h1>
        @endforelse
    </div>
</section>
<!-- /.Posts section -->

<!-- Pagination section -->
<section class="news-pagination">
    <div class="news-pagination-wrapper">
        {{ $posts->links('vendor.pagination.default') }}
    </div>
</section>
<!-- /.Pagination section -->

@endsection
