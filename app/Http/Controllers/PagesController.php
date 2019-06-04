<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\User;

class PagesController extends Controller
{
    public function index() {
        $projects = Project::orderBy('created_at', 'desc')->paginate(40);
        return view('index', compact('projects'));
    }

    public function trending() {
        $projects = Project::orderBy('likes', 'desc')->paginate(40);
        return view('index', compact('projects'));
    }

    public function search(Request $request) {
        $projects = Project::where('tags', 'like', '%' . $request->search . '%')
                            ->orWhere('title', 'like', '%' . $request->search . '%')
                            ->paginate(40);

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

    public function random() {
        return view('pages.random');
    }

}
