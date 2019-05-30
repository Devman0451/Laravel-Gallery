@extends('layouts.app')

@section('content')
<section class="post py-4">
    <div class="post-container">
        <h1>{{ $project->title }} <span>by</span> <a href="/profile/{{$project->owner->profile->id}}">{{ $project->owner->username }}</a></h1>
        <h4>{{ $project->created_at }}</h4>
        <div class="post--image-container py-4">
            <img src="/storage/images/uploads/{{ $project->image }}" alt="upload">
        </div>
        <h4 class="py-4">Description</h4>
        <p class="description">{{ $project->description }} </p>
        <p class="tags"><strong>Tags: </strong>{{ $project->tags }} </p>
        <div class="comments py-4">
            <h4>Comments</h4>
            <ul class="comments-list">

             <li>
                <div class="comment-single">
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