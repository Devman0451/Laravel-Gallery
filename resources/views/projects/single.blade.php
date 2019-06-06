@extends('layouts.app')

@section('content')
<section class="post py-4">
    <div class="post-container">
        <h1>{{ $project->title }} <span>by</span> <a href="{{ route('profile.show', ['profile' => $project->owner->profile]) }}" class="text-light">{{ $project->owner->username }}</a></h1>
        <div class="post--image-container py-4">
            <img src="/storage/images/uploads/{{ $project->owner->username }}/{{ $project->image }}" alt="upload" class="single-image">
        </div>

        @auth
            @if(auth()->user()->id === $project->owner_id)
                <ul class="list-group d-flex flex-row">
                    <li class="px-2"><a href="{{ route('projects.edit', ['project' => $project]) }}" class="btn btn-dark">Edit</a></li>
                    <li class="px-2">
                        <form action="{{ route('projects.destroy', ['project' => $project]) }}" method="post">
                            @csrf
                            @method('DELETE')

                            <input type="submit" value="Delete" class="btn btn-danger">
                        </form>
                    </li>
                </ul>
            @endif

            <ul class="list-group d-flex flex-row mt-2">
                @if (count(App\Like::getUserLike($project->id)->get()) == 0)
                    <li>
                        <form action="{{ route('like.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                            <button class="like-btn" type="submit"><i class="far fa-thumbs-up"></i></button>
                        </form>
                    </li>
                @else
                    <li>
                        <form action="{{ route('like.destroy', ['like' => App\Like::getUserLike($project->id)->first()]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            
                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                            <button class="like-btn" type="submit"><i class="fas fa-thumbs-up"></i></button>
                        </form>
                    </li>
                @endif

                @if (count(App\Favorite::getUserFavorite($project->id)->get()) == 0)
                    <li>
                        <form action=" {{ route('favorite.store')}} " method="post">
                            @csrf
                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                            <button class="favorite-btn" type="submit"><i class="far fa-heart"></i></button>
                        </form>
                    </li>
                @else
                    <li>
                        <form action="\{{ route('favorite.destroy', ['favorite' => App\Favorite::getUserFavorite($project->id)->first()]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            
                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                            <button class="favorite-btn" type="submit"><i class="fas fa-heart"></i></button>
                        </form>
                    </li>
                @endif
            </ul>
        @endauth

        <h4 class="pt-4">Description</h4>
        <h6>Created on: {{ $project->created_at->format("m-d-Y") }}</h6>
        <p class="description">{{ $project->description }} </p>

        <div class="d-flex flex-row justify-content-between tag-container">
            <p class="tags"><strong>Tags: </strong>{{ $project->tags }}</p>
            <p class="tags"><strong>Likes: </strong>{{ $project->likes }}</p>
            <p class="tags"><strong>Favorites: </strong>{{ $project->favorites }}</p>
        </div>

        <div class="comments py-4">
            <h4 class="pb-4">Comments</h4>
            <ul class="comments-list">

            @if (count($project->comments) > 0)
                @foreach($project->comments as $comment)
                    <li>
                        <div class="comment-single pt-1">
                            <p><a href="{{ route('profile.show', ['profile' => $comment->owner->profile]) }}" class="text-light">{{ $comment->owner->username }}</a><span> on </span> {{ $comment->created_at->format('m-d-Y H:i:s') }}</p>
                            <p>{{ $comment->comment }}</p>
                        </div>
                    </li>
                @endforeach
            @endif

            </ul>
        </div>

        @auth
            <form action="{{ route('comment.store') }}?project={{ $project->id }}" method="post" class="comment-form">
                @csrf
                <textarea name="comment" cols="30" rows="10" class="comment"></textarea>
                <input type="submit" name="submit" value="Submit" class="btn-subscribe">
            </form>
        @endauth

    </div>
</section>
@endsection 