@extends('layouts.app')

@section('content')

<section class="signup tos py-4">
    <div class="signup--container">
        <h2>Upload Image</h2>
        
        <form action="/projects" method="post" enctype="multipart/form-data" class="signup-form upload-form">
            @csrf

            <label for="title">Title</label>
            <input type="text" name="title">
            <label for="tags">Tags</label>
            <input type="text" name="tags">
            <label for="image" class="upload--fileupload">Select Image</label>
            <input type="file" name="image" id="image">
            <span class="filename">No File Selected</span>
            <label for="description">Description</label>
            <textarea name="description" cols="30" rows="10"></textarea>
            <input type="submit" name="submit" value="Upload" class="signup-btn">
        </form>
        
    </div>
</section>
    
@endsection