@extends('layouts.app')

@section('content')
    
    <section class="users py-4">
        <h1 class="users-title">Following <a href="{{ route('profile.show', ['profile' => $user->profile]) }}" class="m-0 text-light">{{ $user->username }}</a></h1>
        <div class="users-container py-4">
            <div class="container">
                <table class="users-table">

                    <tr>
                        <th>Avatar</th>
                        <th>Username</th>
                    </tr>
    
                    @if (count($followers) > 0)
    
                        @foreach ($followers as $follower)
    
                            <tr>
                                <td><a href="{{ route('profile.show', ['profile' => $follower->owner->profile]) }}" class="text-light"><img src="{{ $follower->owner->profile->profile_img }}" alt="avatar" class="profile-icon user-icon"></a></td>
                                <td><a href="{{ route('profile.show', ['profile' => $follower->owner->profile]) }}" class="text-light">{{ $follower->owner->username }}</a></td>
                            </tr>
    
                        @endforeach
                    @else 
                        <p class="text-center">No Followers!</p>
                    @endif
    
                </table> 
            </div>
        </div>
        {{$followers->links()}}
    </section>
@endsection