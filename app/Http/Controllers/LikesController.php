<?php

namespace App\Http\Controllers;

use App\Like;
use App\Project;
use Illuminate\Http\Request;

class LikesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $this->validate($request, [
            'project_id' => 'required'
        ]);

        $like = Like::getUserLike($attributes['project_id'])->get();

        $project = Project::getByID($attributes['project_id'])->get();

        if (count($like) == 0 && count($project) == 1) {
            $attributes['owner_id'] = auth()->user()->id;
            Like::create($attributes);
            $likes = ['likes' => ++$project[0]->likes];
            $project[0]->update( $likes);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function destroy(Like $like)
    {
        $project = Project::getByID($like->project_id)->first();
        $project->likes--;
        $project->save();
        $like->delete();
        return redirect()->back();
    }
}
