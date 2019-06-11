<?php

namespace App\Http\Controllers;

use App\Like;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikesController extends Controller
{

    public function index(Project $project) {
        return $project->likes()->with('owner')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project)
    {

        $like = $project->likes()->create([
            'owner_id' => Auth::id()
        ]);

        $like = Like::where('id', $like->id)->with('owner.profile')->first();

        return $like->toJson();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Project $project, Like $like)
    {
        $like->delete();
    }
}
