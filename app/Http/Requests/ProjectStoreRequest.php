<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:60',
            'description' => 'nullable',
            'tags' => 'nullable|max:150',
            'image' => 'required|image|max:2000'
        ];
    }

    public function messages() {
        return [
            'title.required' => 'You need a title for the project',
            'title.max' => 'Title is too long',
            'image.required' => 'Image is required',
            'image.image' => 'Must be an image file',
            'image.max' => 'Image must be < 2MB'
        ];
    }
}
