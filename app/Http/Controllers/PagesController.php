<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\User;

class PagesController extends Controller
{
    public function index() {
        $projects = Project::orderBy('created_at', 'desc')->get();
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
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('pages.users', compact('users'));
    }
}
