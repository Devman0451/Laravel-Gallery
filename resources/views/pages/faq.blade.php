@extends('layouts.app')

@section('content')

    <section class="signup tos py-4">
        <div class="signup--container termsofservice">
            <h2 class="py-2">FAQ</h2>
            <h4>How do I upload my images here?</h4>
            <p>You need to make an account in order to post any images on the site.  You can sign up <a href="{{ route('register') }}">HERE</a> or if you already have an accound you can sign in <a href="{{ route('login') }}">HERE</a></p>
            <h4>Can I upload a profile image?</h4>
            <p>You need to make an account in order to post any images on the site.  You can sign up <a href="{{ route('register') }}">HERE</a> or if you already have an accound you can sign in <a href="{{ route('login') }}">HERE</a></p>
            <h4>How do I delete my images?</h4>
            <p>You need to make an account in order to post any images on the site.  You can sign up <a href="{{ route('register') }}">HERE</a> or if you already have an accound you can sign in <a href="{{ route('login') }}">HERE</a></p>
            <h4>Can I change my username?</h4>
            <p>You need to contact our <a href="{{ route('support') }}">SUPPORT</a> staff in order to change your username</p>
        </div>
    </section>
    
@endsection