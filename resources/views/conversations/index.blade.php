@extends('layouts.app')

@section('content')
    
    <section class="users py-4">
        <h1 class="users-title">Messages</h1>
        <div class="users-container py-4">
            <table class="users-table">

                <tr>
                    <th>Avatar</th>
                    <th>Username</th>
                    <th class="messages-last-post">Last Post</th>
                    <th class="messages-created-at">Started On</th>
                    <th></th>
                </tr>

                @if (count($conversations) > 0)

                    @foreach ($conversations as $conversation)
                        
                    <tr>
                        @if (Auth::user()->id !== $conversation->sender_id )
                            <td><a href="{{ route('profile.show', ['profile' => $conversation->sender_id]) }}" class="text-light"><img src="{{  $conversation->sender->profile->profile_img }}" alt="avatar" class="profile-icon"></a></td>
                            <td><a href="{{ route('profile.show', ['profile' => $conversation->sender_id]) }}" class="text-light">{{ $conversation->sender->username }}</a></td>
                            <td class="messages-last-post">{{ $conversation->updated_at }}</td>
                            <td class="messages-created-at">{{ $conversation->created_at }}</td>
                            <td><a href="{{ route('messages.create') }}?user={{ $conversation->sender_id }}" class="text-white btn btn-success message-btn">Message</a>
                                <form action="{{ route('messages.destroy', ['message' => $conversation->id]) }}" method="post" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-white btn btn-danger delete-btn">Delete</button>    
                                </form>    
                            </td>
                        @else
                            <td><a href="{{ route('profile.show', ['profile' => $conversation->receiver->profile]) }}" class="text-light"><img src="{{  $conversation->receiver->profile->profile_img }}" alt="avatar" class="profile-icon"></a></td>
                            <td><a href="{{ route('profile.show', ['profile' => $conversation->receiver->profile]) }}" class="text-light">{{ $conversation->receiver->username }}</a></td>
                            <td class="messages-last-post">{{ $conversation->updated_at }}</td>
                            <td class="messages-created-at">{{ $conversation->created_at }}</td>
                            <td><a href="{{ route('messages.create') }}?user={{ $conversation->received_id }}" class="text-white btn btn-success message-btn">Message</a>
                                <form action="{{ route('messages.destroy', ['message' => $conversation->id]) }}" method="post" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-white btn btn-danger delete-btn">Delete</button>    
                                </form>    
                            </td>
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