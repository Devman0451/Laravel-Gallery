<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use App\Project;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function index(Project $project) {
        return $project->comments()->with('owner.profile')->latest()->get();
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project)
    {
        $this->validate($request, [
            'comment' => 'required'
        ]);
        
        $comment = $project->comments()->create([
            'comment' => $request->comment,
            'owner_id' => Auth::id()
        ]);
        
        $comment = Comment::where('id', $comment->id)->with('owner.profile')->first();
        
        return $comment->toJson();
    }

        /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}






