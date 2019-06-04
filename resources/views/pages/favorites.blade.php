@extends('layouts.app')

@section('content')
    
    <section class="imagelinks--container"> 
        <ul class="imagelinks--list">
            <li><a href="/profile/{{ $user->id }}" class="m-0">{{ $user->username }}'s</a> Favorites</li>
        </ul>
    </section>
    <section class="gallery">
        @if (count($favorites) > 0)
            @foreach ($favorites as $favorite)
            <a href="/projects/{{ $favorite->project->id }}" class="image-link">
                    <div class="project">
                        <div class="overlay">
                            <div class="info">
                                <img src="{{ $favorite->project->owner->profile->profile_img }}" alt="profile" class="avatar">
                                <div class="image-info">
                                    <div class="title">{{ $favorite->project->title }}</div>
                                    <div class="author">{{ $favorite->project->owner->username }}</div>
                                </div>
                            </div>
                        </div>
                        <img src="/storage/images/uploads/{{ $favorite->project->owner->username }}/thumbs/{{ $favorite->project->image_thumb }}" alt="" class="image">
                    </div>
                </a>
            @endforeach
        @endif
    </section>
    @if (count($favorites) == 0)
    <div class="d-flex justify-content-center">
        <p>No Favorites</p>
    </div>   
    @endif
    <div class="mt-2">
            {{$favorites->links()}}
    </div>
@endsection
