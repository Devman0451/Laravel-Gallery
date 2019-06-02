@extends('layouts.app')

@section('content')
    
    <section class="users py-4">
        <h1 class="users-title">Messages</h1>
        <div class="users-container py-4">
            <table class="users-table">

                <tr>
                    <th>Avatar</th>
                    <th>Username</th>
                    <th>Latest Message</th>
                    <th>Started On</th>
                    <th></th>
                </tr>

                @if (count($conversations) > 0)

                    @foreach ($conversations as $conversation)
                        
                    <tr>
                        @if (Auth::user()->id !== $conversation->sender_id )
                            <td><a href="/profile/{{ $conversation->sender_id }}" class="text-light"><img src="{{  $conversation->sender->profile->profile_img }}" alt="avatar" class="profile-icon"></a></td>
                            <td><a href="/profile/{{ $conversation->sender_id }}" class="text-light">{{ $conversation->sender->username }}</a></td>
                            <td class="text-truncate">{{ $conversation->latestMessage->message }}</td>
                            <td>{{ $conversation->created_at }}</td>
                            <td><a href="/messages/create?user={{ $conversation->sender_id }}" class="text-white btn btn-success message-btn">Message</a>
                                <form action="/messages/{{ $conversation->id }}" method="post" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-white btn btn-danger delete-btn">Delete</button>    
                                </form>    
                            </td>
                        @else
                        @endif

                    </tr>

                    @endforeach
                @else 
                    <p class="text-center">No Messages</p>
                @endif

            </table> 
        </div>
        {{-- {{$users->links()}} --}}
    </section>
@endsection