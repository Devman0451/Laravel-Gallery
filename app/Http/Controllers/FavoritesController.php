<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{

    public function index(Project $project) {
        return $project->favorites()->with('owner')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project)
    {
        $favorite = $project->favorites()->create([
            'owner_id' => Auth::id()
        ]);

        $favorite = Favorite::where('id', $favorite->id)->with('owner.profile')->first();

        return $favorite->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Project $project, Favorite $favorite)
    {
        $favorite->delete();
    }
}
