<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Project;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function __construct() {
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

        $favorite = Favorite::getUserFavorite($attributes['project_id'])->get();

        $project = Project::getByID($attributes['project_id'])->get();

        if (count($favorite) == 0 && count($project) == 1) {
            $attributes['owner_id'] = auth()->user()->id;
            Favorite::create($attributes);
            $favorites = ['favorites' => ++$project[0]->favorites];
            $project[0]->update( $favorites);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favorite $favorite)
    {
        $project = Project::getByID($favorite->project_id)->first();
        $project->favorites--;
        $project->save();
        $favorite->delete();
        return redirect()->back();
    }
}
