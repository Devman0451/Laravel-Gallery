@extends('layouts.app')

@section('content')
    <section class="signup">
        <div class="signup--container py-4">
            <h2>Edit Submission</h2>
            <form action="{{ route('projects.update', ['project' => $project]) }}" method="post" class="signup-form upload-form">
                @csrf
                @method('PATCH')
    
                <label for="title">Title</label>
                <input type="text" name="title" value="{{ $project->title }}">
                @error('title')
                    <p class="text-danger text-center"><strong>{{ $message }}</strong></p>
                @enderror
                
                <label for="tags">Tags</label>
                <input type="text" name="tags" value="{{ $project->tags }}">
                <label for="description">Description</label>
                <textarea name="description" cols="30" rows="10">{{ $project->description }}</textarea>
                <input type="submit" name="submit" value="Upload" class="btn auth-btn mt-2">
            </form>
        </div>
    </section>
@endsection