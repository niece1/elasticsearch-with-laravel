<div class="form-wrapper">
    <label for="title">Title</label>
    <input type="text" name="title" value="{{ old('title') ?? $post->title }}" class="form-input" autofocus>
    <div class="form-error">{{ $errors->first('title') }}</div>
</div>
<div class="form-wrapper">
    <label for="body">Body</label>
    <textarea name="body" id="mytextarea">{{ old('body') ?? $post->body }}</textarea>
    <div class="form-error">{{ $errors->first('body') }}</div>
</div>
<div class="form-wrapper">
    <label for="category_id">Choose category</label>
    <select name="category_id" value="{{ old('category_id') }}" class="form-select">
        <option selected disabled="">Select category</option>
        @foreach ($categories as $category)
        <option value="{{ $category->id }}" {{ $category->id == $post->category_id ? 'selected' : '' }}>
            {{ $category->title }}
        </option>
        @endforeach
    </select>
    <div class="form-error">{{ $errors->first('category_id') }}</div>
</div>
<div class="form-wrapper">
    <label for="image">Set image</label>
    <input type="file" name="image" value="" class="form-image">
    <div class="form-error">{{ $errors->first('image') }}</div>
</div>
@if ($post->image)
<div class="form-wrapper">
    <div class="post-image">	
        <img src="{{ asset('storage/' . $post->image->path) }}"  alt="Image">
        <div class="post-image-overlay">
            <a href="{{ route('image.delete', ['id' => $post->image->id]) }}" class="action-button-delete">
                Delete
            </a>
        </div>	
    </div>
</div>
@endif
<div class="form-wrapper">
    <label for="image_source">Image source</label>
    <input type="text" name="image_source" value="{{ old('image_source') ?? $post->image_source }}" class="form-input">
    <div class="form-error">{{ $errors->first('image_source') }}</div>
</div>
<div class="form-wrapper">
    <label for="time_to_read">Time to read</label>
    <input type="number" name="time_to_read" value="{{ old('time_to_read') ?? $post->time_to_read }}" min="1" max="10" class="form-input">
    <div class="form-error">{{ $errors->first('time_to_read') }}</div>
</div>
