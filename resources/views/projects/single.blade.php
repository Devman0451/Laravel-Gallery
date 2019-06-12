@extends('layouts.app')

@section('content')
<section class="post py-4">
    <div class="post-container">
        <h1>{{ $project->title }} <span>by</span> <a href="{{ route('profile.show', ['profile' => $project->owner->profile]) }}" class="text-light">{{ $project->owner->username }}</a></h1>
        <div class="post--image-container py-4">
            <img src="/storage/images/uploads/{{ $project->owner->username }}/{{ $project->image }}" alt="upload" class="single-image">
        </div>

        @auth
            @can('update', $project)
                <ul class="list-group d-flex flex-row">
                    <li class="px-2"><a href="{{ route('projects.edit', ['project' => $project]) }}" class="btn btn-dark">Edit</a></li>
                    <li class="px-2">
                        @can('delete', $project)
                            <form action="{{ route('projects.destroy', ['project' => $project]) }}" method="post">
                                @csrf
                                @method('DELETE')

                                <input type="submit" value="Delete" class="btn btn-danger">
                            </form>
                        @endcan
                    </li>
                </ul>
            @endcan

            <ul class="list-group d-flex flex-row mt-2">

                <li>
                    <button class="like-btn" type="submit"><i :class="[hasLiked ? 'fas' : 'far', 'fa-thumbs-up']" @click="submitLike"></i></button>
                </li>

                <li>
                    <button class="favorite-btn" type="submit"><i :class="[hasFavorited ? 'fas' : 'far', 'fa-heart']" @click="submitFavorite"></i></button>
                </li>
            </ul>
        @endauth

        <h4 class="pt-4">Description</h4>
        <h6>Created on: {{ $project->created_at }}</h6>
        <p class="description">{{ $project->description }} </p>

        <div class="d-flex flex-row justify-content-between tag-container">
            <p class="tags"><strong>Tags: </strong>{{ $project->tags }}</p>
            <p class="tags"><strong>Likes: </strong>@{{ likes.length }}</p>
            <p class="tags"><strong>Favorites: </strong>@{{ favorites.length }}</p>
        </div>

        <div class="comments py-4">
            <h4 class="pb-4">Comments</h4>
            <ul class="comments-list">

                <li v-for="comment in comments">
                    <div class="comment-block">
                        <a :href="'{{url('/profile')}}/' + comment.owner.profile.id"><img :src="comment.owner.profile.profile_img" alt="profile" class="comment-img"></a>
                        <div class="comment-single">
                            <p><a :href="'{{url('/profile')}}/' + comment.owner.profile.id" class="text-light">@{{ comment.owner.username }}</a><span> on </span> @{{ comment.created_at }}</p>
                            <p>@{{ comment.comment }}</p>
                            @can('update', $project)
                                {{-- <button class="btn btn-dark reply-btn">Reply</button> --}}
                                {{-- <comment /> --}}
                            @endcan
                        </div>
                    </div>

                    @can('update', $project)
                        {{-- <div class="comment-form">
                            <textarea name="comment" cols="30" rows="10" class="comment" v-model="commentField"></textarea>
                            <input type="submit" name="submit" value="Submit" class="btn-subscribe" :disabled="commentField.length == 0" @click.prevent="postComment">
                        </div> --}}
                        <comment />
                    @endcan
                </li>

            </ul>
        </div>

        @auth
            <div class="comment-form">
                <textarea name="comment" cols="30" rows="10" class="comment" v-model="commentField"></textarea>
                <input type="submit" name="submit" value="Submit" class="btn-subscribe" :disabled="commentField.length == 0" @click.prevent="postComment">
            </div>
        @endauth

    </div>
</section>
@endsection 

@section('scripts')
    <script>
        const app = new Vue({
            el: '#app',
            data: {
                comments: {},
                commentField: '',
                favorite: {!! Auth::check() && App\Favorite::getUserFavorite($project->id)->first() ? App\Favorite::getUserFavorite($project->id)->first()->toJson() : 'null' !!},
                favorites: [],
                like: {!! Auth::check() && App\Like::getUserLike($project->id)->first() ? App\Like::getUserLike($project->id)->first()->toJson() : 'null' !!},
                likes: [],
                error: false,
                project: {!! $project->toJson() !!},
                user: {!! Auth::check() ? Auth::user()->toJson() : 'null' !!}
            },

            mounted() {
                this.getComments();
                this.getLikes();
                this.getFavorites();
            },

            methods: {

                getComments() {
                    axios.get(`/api/projects/${this.project.id}/comments`)
                        .then(res => this.comments = res.data)
                        .catch(res => this.error = true)
                },
                postComment() {
                    axios.post(`/api/projects/${this.project.id}/comment`, {
                        api_token: this.user.api_token,                       
                        comment : this.commentField
                    })
                    .then(res => {
                        this.comments.unshift(res.data);
                        this.commentField = '';
                    })
                    .catch(err => this.error = true);
                },


                getLikes() {
                    axios.get(`/api/projects/${this.project.id}/likes`)
                        .then(res => {
                            this.likes = res.data
                        })
                        .catch(err => this.error = true)
                },
                postLike() {
                    axios.post(`/api/projects/${this.project.id}/like`, {
                        api_token: this.user.api_token, 
                        })
                        .then(res => {
                            this.likes.unshift(res.data);
                            this.like = res.data;
                        })
                        .catch(err => this.error = true);
                },
                deleteLike() {
                    axios.delete(`/api/projects/${this.project.id}/like/${this.like.id}`, {
                            api_token: this.user.api_token,
                            headers: {
                                'Accept': 'application/json',
                                'Authorization': `Bearer ${this.user.api_token}`
                            } 
                        })
                        .then(res => {
                            this.likes = this.likes.filter(el => el.id !== this.like.id);
                            this.like = null;
                        })
                        .catch(err => this.error = true);   
                },
                submitLike() {
                    if(!this.hasLiked) {
                        this.postLike();
                    } else {
                        this.deleteLike();
                    }
                },


                getFavorites() {
                    axios.get(`/api/projects/${this.project.id}/favorites`)
                        .then(res => {
                            this.favorites = res.data
                        })
                        .catch(err => this.error = true)
                },
                postFavorite() {
                    axios.post(`/api/projects/${this.project.id}/favorite`, {
                        api_token: this.user.api_token, 
                        })
                        .then(res => {
                            this.favorites.unshift(res.data);
                            this.favorite = res.data;
                        })
                        .catch(err => this.error = true);
                },
                deleteFavorite() {
                    axios.delete(`/api/projects/${this.project.id}/favorite/${this.favorite.id}`, {
                            api_token: this.user.api_token,
                            headers: {
                                'Accept': 'application/json',
                                'Authorization': `Bearer ${this.user.api_token}`
                            } 
                        })
                        .then(res => {
                            this.favorites = this.favorites.filter(el => el.id !== this.favorite.id);
                            this.favorite = null;
                        })
                        .catch(err => this.error = true);   
                },
                submitFavorite() {
                    if(!this.hasFavorited) {
                        this.postFavorite();
                    } else {
                        this.deleteFavorite();
                    }
                }
            },

            computed: {

                hasLiked() {
                    return this.like ? true : false;
                },
                hasFavorited() {
                    return this.favorite ? true : false;
                }
            }
        });
    </script>
@endsection