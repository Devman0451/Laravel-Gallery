<?php

namespace App\Http\Controllers;

use App\Follower;
use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowersController extends Controller
{

    public function index(Profile $profile) {
        return $profile->owner->followers()->with('owner')->get();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Profile $profile)
    {
        $follower = $profile->owner->followers()->create([
            'follower_id' => Auth::id()
        ]);

        $follower = Follower::where('id', $follower->id)->with('owner')->first();

        return $follower->toJson();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Follower  $follower
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Profile $profile, Follower $follower)
    {
        $follower->delete();
    }
}
