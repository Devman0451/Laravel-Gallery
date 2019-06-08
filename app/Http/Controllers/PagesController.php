<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\User;
use App\Favorite;
use App\Follower;

class PagesController extends Controller
{
    public function index() {
        $projects = Project::orderByDate()->paginate(40);
        return view('index', compact('projects'));
    }

    public function trending() {
        $projects = Project::orderByLikes()->paginate(40);
        return view('index', compact('projects'));
    }

    public function search(Request $request) {
        $projects = Project::searchTagsAndTitles($request->search)->paginate(40);

        return view('index', compact('projects'));
    }

    public function privacy() {
        return view('pages.privacy');
    }

    public function support() {
        return view('pages.support');
    }

    public function tos() {
        return view('pages.tos');
    }

    public function faq() {
        return view('pages.faq');
    }

    public function about() {
        return view('pages.about');
    }

    public function users() {
        $users = User::orderBy('created_at', 'desc')->paginate(15);
        return view('pages.users', compact('users'));
    }

    public function favorites(Request $request) {
        $user = User::where('id', $request['user'])->first();
        if ($user == null) {
            return redirect()->back();
        }
        $favorites = Favorite::where('owner_id', $request['user'])->paginate(40);
        return view('pages.favorites', compact('user', 'favorites'));
    }

    public function followers(Request $request) {
        $user = User::where('id', $request['user'])->first();
        if ($user == null) {
            return redirect()->back();
        }
        $followers = Follower::where('followed_id', $request['user'])->paginate(40);
        return view('pages.followers', compact('user', 'followers'));
    }

    public function random() {
        return view('pages.random');
    }

}
