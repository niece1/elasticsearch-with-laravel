@extends('layouts.frontend')

@section('title', 'Search')

@section('content')

<!-- Title jumbotron -->
<section class="title-jumbotron">
    <div class="parallax-text">
        <h1>Search</h1>
    </div>
</section>
<!-- /.Title jumbotron -->

<!-- Posts section -->
<section class="news">
    <h1>Last news</h1>
    <div class="news-wrapper">
        @forelse ($customers as $customer)
        <div class="item">
            <div class="item-content">
                <a href="#">
                    <h6>{{ $customer->name }}</h6>
                </a>
                <p class="item-blog-author">
                    <i class="fas fa-user-edit"></i>
                    <a href="#">{{ $customer->username }}</a>
                </p>
                <p class="item-blog-comment">
                    Comments: 12
                </p>
                <p class="item-blog-date">{{ $customer->email }}</p>                
                <div class="blog-line">
                </div>
                <div class="item-blog-bottom">
                    <a href="#" class="button">Read</a>
                </div>
            </div>
        </div>
        @empty
        <h1>No results for search criteria</h1>
        @endforelse
    </div>
</section>
<!-- /.Posts section -->

@endsection
