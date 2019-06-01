@extends('layouts.app')

@section('content')

@auth
    <div class="container my-5">
        <div class="row">
            <div class="col-11 m-auto message-container">

                <div class="message-title-header d-flex flex-row">
                    <img src="/storage/images/static/default.jpg" alt="profile" class="rounded-circle">
                    <div class="message-title-header--text mt-1 ml-3">
                        <h4 class="text-left">Message with User</h4>
                        <h6>{{ count($conversation->messages)}} Messages</h6>
                    </div>
                </div>

                <div class="message-window">

                    <div class="message-user-message">
                        <div class="message-title-header--text mt-2 d-flex flex-row">
                            <img src="/storage/images/static/default.jpg" alt="profile" class="rounded-circle message-img">
                            <p class="text-left message-user-text">Hello</p>
                        </div>
                        <p class="text-left message-user-date"><span class="message-date">8:30 PM, Today</span></p>
                    </div>

                    <div class="message-user-message">
                        <div class="message-title-header--text mt-1 d-flex flex-row">
                            <img src="/storage/images/static/default.jpg" alt="profile" class="rounded-circle message-img">
                            <p class="text-left message-user-text">You there?</p>
                        </div>
                        <p class="text-left message-user-date"><span class="message-date">8:33 PM, Today</span></p>
                    </div>
                    
                    <div class="message-user-message foreign-message">
                        <div class="message-title-header--text mt-1 d-flex flex-row foreign-user">
                            <p class="text-left message-user-text foreign-text">Yep, I am now at least :D</p>
                            <img src="/storage/images/static/default.jpg" alt="profile" class="rounded-circle message-img">
                        </div>
                        <p class="text-right message-user-date"><span class="message-date">8:45 PM, Today</span></p>
                    </div>


                </div>

                <div class="message-form-container">
                    <form action="/messages?user={{ $send_id }}" method="post" class="message-form d-flex flex-row">
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