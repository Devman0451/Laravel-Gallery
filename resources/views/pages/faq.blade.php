@extends('layouts.app')

@section('content')

    <section class="signup tos py-4">
        <div class="signup--container termsofservice">
            <h2 class="py-2">FAQ</h2>
            <h4>How do I upload my images here?</h4>
            <p>You need to make an account in order to post any images on the site.  You can sign up <a href="{{ route('register') }}">HERE</a> or if you already have an accound you can sign in <a href="{{ route('login') }}">HERE</a></p>
            <h4>Why can't I reply to a comment?</h4>
            <p>We believe that the image's uploader should have the final word on a comment so we limit it to one reply from the uploader.  If you're having a problem replying on your own image's comments, please contact our <a href="{{ route('support') }}">SUPPORT</a> staff</p>
            <h4>Can I upload a profile image?</h4>
            <p>Yes, click on edit in the dropdown menu and you can upload a profile image.  You need to make an account in order to post any images on the site.  You can sign up <a href="{{ route('register') }}">HERE</a> or if you already have an accound you can sign in <a href="{{ route('login') }}">HERE</a></p>
            <h4>How do I delete my images?</h4>
            <p>Log in and go to your post and click the delete button beneath your image.  You need to make an account in order to post any images on the site.  You can sign up <a href="{{ route('register') }}">HERE</a> or if you already have an accound you can sign in <a href="{{ route('login') }}">HERE</a></p>
            <h4>Can I change my username?</h4>
            <p>You need to contact our <a href="{{ route('support') }}">SUPPORT</a> staff in order to change your username</p>
        </div>
    </section>
    
@endsection