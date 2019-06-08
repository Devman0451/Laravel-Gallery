<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;

class ProjectsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show']);
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
        return view('projects.upload');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectStoreRequest $request)
    {
        $attributes = $request->validated();

        $fileNameToStore = processImage($request->file('image'), auth()->user()->username);

        $attributes['image'] = $fileNameToStore;
        $attributes['image_thumb'] = $fileNameToStore;
        $attributes['owner_id'] = auth()->id();

        Project::create($attributes);

        return redirect('/')->with('success', 'Upload Successful!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('projects.single', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectUpdateRequest $request, Project $project)
    {
        $this->authorize('update', $project);

        $attributes = $request->validated();

        $project->update($attributes);

        return redirect('/projects/' . $project->id)->with(compact('project'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        Storage::delete('public/images/uploads/' . auth()->user()->username . '/' . $project->image);
        Storage::delete('public/images/uploads/' . auth()->user()->username . '/thumbs/' . $project->image_thumb);

        $project->delete();

        return redirect('/')->with('success', 'Post Deleted');
    }

}
