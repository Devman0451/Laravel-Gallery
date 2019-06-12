@extends('layouts.app')

@section('content')
    <section class="post">
        <div class="profile-banner" style="
            background: url('{{ $profile->banner_img }}');
            background-color: rgb(45, 45, 45);
            background-size: cover;
            background-repeat: no-repeat;
            ">
            @auth
                @can('update', $profile)
                    <a href="{{ route('profile.edit', ['profile' => $profile]) }}" class="text-white banner-button" title="Upload Banner Image"><i class="fas fa-arrow-up"></i></a>
                @endcan

                @cannot('update', $profile)
                    <a href="{{ route('messages.create') }}?user={{ $profile->owner->id }}" class="text-white banner-button btn btn-success message-btn">Message</a>
                @endcannot
            @endauth
            <img src="{{ $profile->profile_img }}" alt="profile icon" class="profile-icon">
            <div class="profile-info pb-3">
                <h1> {{ $profile->owner->username }} </h1>
                <p> {{ $profile->location }} </p>
                <p class="profile-description"> {{ $profile->description }} </p>
            </div>
            @auth
                @cannot('update', $profile)
                    {{-- @if (count(App\Follower::getUserFollowing($profile->owner->id)->get()) == 0) --}}
                        
                        {{-- <form action="{{ route('follower.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="followed_id" value="{{ $profile->owner->id }}"> --}}
                        <button class="text-white banner-button banner-button-message btn btn-primary follow-btn" type="submit" @click="handleFollow">@{{ buttonText }}</button>
                        {{-- </form> --}}
            
                    {{-- @else
                        
                        <form action="{{ route('follower.destroy', ['follower' => App\Follower::getUserFollowing($profile->owner->id)->first()]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            
                            <button class="text-white banner-button banner-button-message btn btn-danger follow-btn" type="submit">Unfollow</button>
                        </form>
                        
                    @endif --}}
                @endcannot
            @endauth
        </div>

        <div class="profile-links d-flex justify-content-center">
            <ul class="profile-links--list d-flex py-2 px-5">
                <a href="{{ route('favorites') }}?user={{ $profile->owner->id }}" class="text-light"><li class="profile-links--listitem">Favorites <span class="text-secondary">({{ count($profile->owner->favorites) }})</span></li></a>
                <a href="{{ route('followers') }}?user={{ $profile->owner->id }}" class="text-light ml-3"><li class="profile-links--listitem">Followers <span class="text-secondary">(@{{ followers.length }})</span></li></a>
            </ul>
        </div>
        <div class="gallery">

                @if (count($profile->owner->projects) > 0)
                @foreach ($profile->owner->projects as $project)
                <a href="{{ route('projects.show', ['project' => $project]) }}" class="image-link">
                        <div class="project">
                            <div class="overlay">
                                <div class="info">
                                <img src="{{ $profile->profile_img }}" alt="profile" class="avatar">
                                    <div class="image-info">
                                        <div class="title">{{ $project->title }}</div>
                                        <div class="author">{{ $project->owner->username }}</div>
                                    </div>
                                </div>
                            </div>
                            <img src="/storage/images/uploads/{{ $project->owner->username }}/thumbs/{{ $project->image_thumb }}" alt="" class="image">
                        </div>
                    </a>
                @endforeach
            @endif

        </div>
    </section>
@endsection

@section('scripts')
    <script>
        const app = new Vue({
            el: '#app',
            data: {
                buttonText: 'Follow',
                follower: {!! Auth::check() && App\Follower::getUserFollowing($profile->owner->id)->first() ? App\Follower::getUserFollowing($profile->owner->id)->first()->toJson() : 'null' !!},
                followers: [],
                profile: {!! $profile->toJson() !!},
                error: false,
                user: {!! Auth::check() ? Auth::user()->toJson() : 'null' !!},
            },

            mounted() {
                this.getFollowers();
                this.handleButtonText();
            },

            methods: {
                getFollowers() {
                    axios.get(`/api/profiles/${this.profile.id}/followers`)
                        .then(res => this.followers = res.data)
                        .catch(res => this.error = true)
                },
                follow() {
                    axios.post(`/api/profiles/${this.profile.id}/follower`, {
                        api_token: this.user.api_token,  
                    })
                    .then(res => {
                        this.followers.unshift(res.data);
                        this.buttonText = 'Unfollow';
                        this.follower = res.data;
                    })
                    .catch(res => this.error = true)
                },
                unfollow() {
                    axios.delete(`/api/profiles/${this.profile.id}/follower/${this.follower.id}`, {
                        api_token: this.user.api_token,
                            headers: {
                                'Accept': 'application/json',
                                'Authorization': `Bearer ${this.user.api_token}`
                            } 
                        })
                        .then(res => {
                            this.followers = this.followers.filter(el => el.id !== this.follower.id);
                            this.follower = null;
                            this.buttonText = 'Follow';
                        })
                        .catch(err => this.error = true);   
                },
                handleFollow() {
                    if (!this.isFollowing) {
                        this.follow();
                    } else {
                        this.unfollow();
                    }
                },
                handleButtonText() {
                    if (!this.isFollowing) {
                        this.buttonText = "Follow";
                    } else {
                        this.buttonText = "Unfollow";
                    }
                }
            },

            computed: {
                isFollowing() {
                    return this.follower ? true : false;
                }
            }
        })
    </script>
@endsection