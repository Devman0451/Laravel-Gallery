@extends('layouts.app')

@section('content')
    
    <section class="users py-4">
        <h1 class="users-title">Users</h1>
        <div class="users-container py-4">
            <table class="users-table">

                <tr>
                    <th>Avatar</th>
                    <th>Username</th>
                    <th>Date Joined</th>
                </tr>

                @if (count($users) > 0)

                    @foreach ($users as $user)
                        
                    <tr>
                        <td><a href="/profile/{{ $user->profile->id }}" class="text-light"><img src="" alt="avatar" class="profile-icon"></a></td>
                        <td><a href="/profile/{{ $user->profile->id }}" class="text-light">{{ $user->username }}</a></td>
                        <td>{{ $user->created_at }}</td>
                    </tr>

                    @endforeach
                @else 
                    <p class="text-center">No users registered!</p>
                @endif

            </table> 
        </div>
        {{$users->links()}}
    </section>
@endsection