<?php

namespace App\Http\Controllers;

use App\Profile;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;

class ProfilesController extends Controller
{
            /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => [
            'show'
        ]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $attributes = $this->validate($request, [
        //     'location' => 'nullable|max:50',
        //     'description' => 'nullable',
        //     'profile_img' => 'image|nullable|max:200|dimensions:width=100,height=100',
        // ]);

        // $attributes['profile_img'] = '/storage/images/static/default.jpg';
        // $attributes['owner_id'] = auth()->user()->id;

        // Profile::create($attributes);

        // return redirect('/')->with('success', 'Successfully Registered!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        return view('profiles.profile', compact('profile'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        $this->authorize('update', $profile);
        return view('profiles.edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileUpdateRequest $request, Profile $profile)
    {
        $this->authorize('update', $profile);

        $attributes = $this->updateImage($request, $profile);

        $profile->update($attributes);

        return redirect('/profile/' . $profile->id)->with(compact('profile'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        $this->authorize('delete', $profile);
    }

    /**
     * Handle image update for profile
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return 
     */

    private function updateImage($request, $profile) {
        $attributes = $request->validated();

        if ($request->hasFile('profile_img')) {
            if($profile->profile_img !== '/storage/images/static/default.jpg') {
                $file = explode('/', $profile->profile_img);
                Storage::delete('public/images/uploads/' . auth()->user()->username . '/profile/' . $file[6]);
            }
            $attributes['profile_img'] = profileImage($request->file('profile_img'), auth()->user()->username);
        }

        if ($request->hasFile('banner_img')) {
            if($profile->banner_img !== null) {
                $file = explode('/', $profile->banner_img);
                Storage::delete('public/images/uploads/' . auth()->user()->username . '/profile/' . $file[6]);
            }
            $attributes['banner_img'] = profileImage($request->file('banner_img'), auth()->user()->username);
        }

        return $attributes;
    }    
}
