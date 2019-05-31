<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

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
    public function store(Request $request)
    {
        $attributes = $this->validate($request, [
            'title' => 'required|max:100',
            'description' => 'nullable',
            'tags' => 'nullable',
            'image' => 'required|image|max:2000'
        ]);

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
        if (auth()->user()->id !== $project->owner_id) {
            return redirect('/')->with('error', 'Unauthorized Page');
        }

        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        if(auth()->user()->id !== $project->owner_id) {
            return redirect('/')->with('error', 'Umauthorized Page');
        }

        $attributes = $this->validate($request, [
            'title' => 'required|max:100',
            'description' => 'nullable',
            'tags' => 'nullable',
        ]);

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
        if (auth()->user()->id !== $project->owner_id) {
            return redirect('/')->with('error', 'Unauthorized Page');
        }

        Storage::delete('public/images/uploads/' . auth()->user()->username . '/' . $project->image);
        Storage::delete('public/images/uploads/' . auth()->user()->username . '/thumbs/' . $project->image_thumb);

        $project->delete();

        return redirect('/')->with('success', 'Post Deleted');
    }

    //  /**
    //  * Generate image and a thumbnail
    //  *@param UploadedFile image file 
    // * @param string username of the user uploading the image. 
    //  * @return String
    //  */
    // protected function processImage($image, $username) {

    //     $fileNameWithExt = $image->getClientOriginalName();
    //     $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
    //     $extension = $image->getClientOriginalExtension();
    //     $fileNameToStore = $fileName . '_' . uniqid('', true) . '.' . $extension;
    //     $path = 'public/images/uploads/' . $username;
    //     $image->storeAs($path, $fileNameToStore);

    //     $thumbPath = public_path('storage/images/uploads/' . $username . '/thumbs');

    //     if (!file_exists($thumbPath)) {
    //         mkdir($thumbPath, 0777, true);
    //     }

    //     create_thumbnail($image->path(), $extension, $thumbPath . '/' . $fileNameToStore);

    //     return $fileNameToStore;
    // }
}
