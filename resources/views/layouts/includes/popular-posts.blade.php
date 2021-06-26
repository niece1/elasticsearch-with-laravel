<h5>Popular posts</h5>
@foreach ($popular_posts as $post)
<ul>
    <li>
        @if ($post->image)
        <div class="image-holder">
            <a href="#">
                <img class="lazyload"
                    src="{{ asset('storage/' . $post->image->path) }}" width="92" height="69" alt="Image">
            </a>
        </div>
        @endif
        <small>{{ $post->date }}</small>
        <a href="#" class="popular-link-title">
            <p>{{ $post->title }}</p>
        </a>
    </li>
</ul>
@endforeach
