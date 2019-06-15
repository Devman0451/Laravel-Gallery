@extends('layouts.app')

@section('content')

@auth
    <messages 
        :user="user"
        :other-user="otherUser"
        :conversation="conversation"/>
    
@endauth
@endsection

@section('scripts')
    <script>
        const app = new Vue({
            el: '#app',
            data() {
                return {
                    user: {!! Auth::check() ? Auth::user()->toJson() : 'null'  !!},
                    otherUser: {!! $user !!},
                    conversation: {!! $conversation !!}
                }
            }
        })
    </script>
@endsection