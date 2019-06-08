<?php

namespace App\Http\Controllers;

use App\Follower;
use Illuminate\Http\Request;

class FollowersController extends Controller
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
            'followed_id' => 'required'
        ]);

        $follower = Follower::getUserFollowing($attributes['followed_id'])->get();

        if (count($follower) == 0) {
            $attributes['follower_id'] = auth()->user()->id;
            Follower::create($attributes);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Follower  $follower
     * @return \Illuminate\Http\Response
     */
    public function destroy(Follower $follower)
    {
        $follower->delete();
        return redirect()->back();
    }
}
