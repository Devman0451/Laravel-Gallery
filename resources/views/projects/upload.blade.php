@extends('layouts.app')

@section('content')

<section class="signup tos py-4">
    <div class="signup--container">
        <h2>Upload Image</h2>
        
        <form action="{{ route('projects.store') }}" method="post" enctype="multipart/form-data" class="signup-form upload-form">
            @csrf

            <label for="title">Title</label>
            <input type="text" name="title" value="{{ old('title') }}">
            <label for="tags">Tags</label>
            <input type="text" name="tags" value="{{ old('tags') }}">
            <label for="image" class="upload--fileupload">Select Image</label>
            <input type="file" name="image" id="image">
            <span class="filename">No File Selected</span>
            <label for="description">Description</label>
            <textarea name="description" cols="30" rows="10">{{ old('description') }}</textarea>
            <input type="submit" name="submit" value="Upload" class="btn auth-btn mt-2">
        </form>
        
    </div>
</section>
    
@endsection