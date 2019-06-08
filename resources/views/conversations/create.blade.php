@extends('layouts.app')

@section('content')

@auth
    <div class="container my-5">
        <div class="row">
            <div class="col-11 m-auto message-container">

                <div class="message-title-header d-flex flex-row">
                    <a href="{{ route('profile.show', ['profile' => $user->profile]) }}"><img src="{{ $user->profile->profile_img }}" alt="profile" class="rounded-circle"></a>
                    <div class="message-title-header--text mt-1 ml-3">
                        <h4 class="text-left">Message with <a href="{{ route('profile.show', ['profile' => $user->profile]) }}" class="text-light">{{ $user->username }}</a></h4>
                        <h6>{{ count($conversation->messages) }} Messages</h6>
                    </div>
                </div>

                <div class="message-window">

                    @if(count($conversation->messages) > 0)

                        @foreach ($conversation->messages as $message)

                            @if(auth()->user()->id == $message->sender_id)
                                <div class="message-user-message">
                                    <div class="message-title-header--text mt-2 d-flex flex-row">
                                        <img src="{{ auth()->user()->profile->profile_img }}" alt="profile" class="rounded-circle message-img">
                                        <p class="text-left message-user-text">{{ $message->message }}</p>
                                    </div>
                                    <p class="text-left message-user-date"><span class="message-date">{{ $message->created_at }}</span></p>
                                </div>
                            @else 
                                <div class="message-user-message foreign-message">
                                    <div class="message-title-header--text mt-1 d-flex flex-row foreign-user">
                                        <p class="text-left message-user-text foreign-text">{{ $message->message }}</p>
                                        <img src="{{ $user->profile->profile_img }}" alt="profile" class="rounded-circle message-img">
                                    </div>
                                    <p class="text-right message-user-date"><span class="message-date">{{ $message->created_at }}</span></p>
                                </div>
                            @endif
                        @endforeach

                    @endif

                </div>

                <div class="message-form-container">
                    <form action="{{ route('messages.store') }}?user={{ $user->id }}" method="post" class="message-form d-flex flex-row">
                        @csrf
                        <textarea class="message-textarea" name="message" cols="30" rows="10" placeholder="Type your message"></textarea>
                        <button type="submit" class="text-white message-btn-send"><i class="fas fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endauth
</section>
@endsection