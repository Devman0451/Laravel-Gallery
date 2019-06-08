@extends('layouts.app')

@section('content')
<section class="signup">
    <div class="signup--container py-4">
        <h2>Edit Profile</h2>

        
        <form action="{{ route('profile.update', ['profile' => $profile]) }}" method="post" class="signup-form" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <label for="location">Location</label>
            <input type="text" name="location"  value="{{ $profile->location }}" class="form-control @error('location') is-invalid @enderror">
            @error('location')
                    <p class="text-danger text-center"><strong>{{ $message }}</strong></p>
            @enderror

            <label for="description">Description</label>
            <input type="text" name="description" value="{{ $profile->description }}" class="form-control @error('description') is-invalid @enderror">
            @error('description')
                    <p class="text-danger text-center"><strong>{{ $message }}</strong></p>
            @enderror

            <label>Profile Image *100 x 100 max*</label>
            <label for="image" class="upload--fileupload">Select Image</label>
            <input type="file" name="profile_img" id="image">
            <span class="filename">No File Selected</span>
            @error('profile_img')
                    <p class="text-danger text-center"><strong>{{ $message }}</strong></p>
            @enderror

            <label>Banner Image *1920 x 365 max*</label>
            <label for="image2" class="upload--fileupload">Select Image</label>
            <input type="file" name="banner_img" id="image2">
            <span class="filename2">No File Selected</span>
            @error('banner_img')
                    <p class="text-danger text-center"><strong>{{ $message }}</strong></p>
            @enderror
            
            <input type="submit" name="submit" value="Submit" class="signup-btn">
        </form>
    </div>
</section>
@endsection