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

        $like = Like::where('owner_id', auth()->user()->id)
                    ->where('project_id', $attributes['project_id'])
                    ->get();

        $project = Project::where('id', $attributes['project_id'])->get();

        if (count($like) == 0 && count($project) == 1) {
            $attributes['owner_id'] = auth()->user()->id;
            Like::create($attributes);
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
        $like->delete();
        return redirect()->back();
    }
}
