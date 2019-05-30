@extends('layouts.app')

@section('content')
<section class="signup">
    <div class="signup--container py-4">
        <h2>Edit Profile</h2>

        <form action="/profile/{{ $profile->id }}" method="post" class="signup-form" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <label for="last">* Location</label>
            <input type="text" name="location"  value="{{ $profile->location }}">
            <label for="uid">* Description</label>
            <input type="text" name="description" value="{{ $profile->description }}">
            <label>Profile Image</label>
            <label for="image" class="upload--fileupload">Select Image</label>
            <input type="file" name="image" id="image">
            <span class="filename">No File Selected</span>
            <input type="submit" name="submit" value="Submit" class="signup-btn">
        </form>
    </div>
</section>
@endsection