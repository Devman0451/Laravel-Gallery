@extends('layouts.app')

@section('content')
    
    <section class="imagelinks--container"> 
        <ul class="imagelinks--list">
            <li><a href="" rel="">Lastest</a></li>
            <li><a href="" rel="">Trending</a></li>
            <li><a href="/random" rel="">Random</a></li>
        </ul>
    </section>

    <section class="gallery">
        @if (count($projects) > 0)
            @foreach ($projects as $project)
            <a href="/projects/{{ $project->id }}" class="image-link">
                    <div class="project">
                        <div class="overlay">
                            <div class="info">
                                <img src="{{ $project->owner->profile->profile_img }}" alt="profile" class="avatar">
                                <div class="image-info">
                                    <div class="title">{{ $project->title }}</div>
                                    <div class="author">{{ $project->owner->username }}</div>
                                </div>
                            </div>
                        </div>
                        <img src="/storage/images/uploads/{{ $project->owner->username }}/thumbs/{{ $project->image_thumb }}" alt="" class="image">
                    </div>
                </a>
            @endforeach
        @endif
    </section>

@endsection
