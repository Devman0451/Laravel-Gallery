@extends('layouts.app')

@section('content')
<section class="post py-4">
    <div class="post-container">
        <h1>{{ $project->title }} <span>by</span> <a href="/profile/{{$project->owner->profile->id}}" class="text-light">{{ $project->owner->username }}</a></h1>
        <div class="post--image-container py-4">
            <img src="/storage/images/uploads/{{ $project->owner->username }}/{{ $project->image }}" alt="upload">
        </div>

        @auth
            @if(auth()->user()->id === $project->owner_id)
                <ul class="list-group d-flex flex-row">
                    <li class="px-2"><a href="/projects/{{ $project->id }}/edit" class="btn btn-dark">Edit</a></li>
                    <li class="px-2">
                        <form action="/projects/{{ $project->id }}" method="post">
                            @csrf
                            @method('DELETE')

                            <input type="submit" value="Delete" class="btn btn-danger">
                        </form>
                    </li>
                </ul>
            @endif
        @endauth

        <h4 class="pt-4">Description</h4>
        <h6>Created on: {{ $project->created_at->format("m-d-Y") }}</h6>
        <p class="description">{{ $project->description }} </p>
        <p class="tags"><strong>Tags: </strong>{{ $project->tags }} </p>
        <div class="comments py-4">
            <h4 class="pb-4">Comments</h4>
            <ul class="comments-list">

             <li>
                <div class="comment-single pt-1">
                    <p>TestUser<span> on </span> 12/11/2019</p>
                    <p>Test comment</p>
                </div>
            </li>

            </ul>
        </div>

        @auth
            <form action="includes/comment.inc.php" method="post" class="comment-form">
                @csrf

                <input type="hidden" name="img_id" value="' . $id . '">
                <textarea name="comment" cols="30" rows="10" class="comment"></textarea>
                <input type="submit" name="submit" value="Submit" class="btn-subscribe">
            </form>
        @endauth

    </div>
</section>
@endsection 