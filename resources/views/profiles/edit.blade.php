@extends('layouts.app')

@section('content')
<section class="signup">
    <div class="signup--container py-4">
        <h2>Edit Profile</h2>

        
        <ul>
            @foreach ($errors->all() as $error)
                <li class="alert-danger">{{ $error }}</li>
            @endforeach
        </ul>

        <form action="{{ route('profile.update', ['profile' => $profile]) }}" method="post" class="signup-form" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <label for="last">* Location</label>
            <input type="text" name="location"  value="{{ $profile->location }}">
            <label for="uid">* Description</label>
            <input type="text" name="description" value="{{ $profile->description }}">
            <label>Profile Image *100 x 100*</label>
            <label for="image" class="upload--fileupload">Select Image</label>
            <input type="file" name="profile_img" id="image">
            <span class="filename">No File Selected</span>

            <label>Banner Image *1920 x 365*</label>
            <label for="image2" class="upload--fileupload">Select Image</label>
            <input type="file" name="banner_img" id="image2">
            <span class="filename2">No File Selected</span>

            @error('banner_img')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $error }}</strong>
                </span>
            @enderror
            
            <input type="submit" name="submit" value="Submit" class="signup-btn">
        </form>
    </div>
</section>
@endsection