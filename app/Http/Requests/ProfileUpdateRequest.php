<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
            'location' => 'nullable|max:50',
            'description' => 'nullable|max:100',
            'profile_img' => 'image|nullable|max:200|dimensions:max_width=100,max_height=100',
            'banner_img' => 'image|nullable|max:2000|dimensions:max_width=2560,max_height=365'
        ];
    }
}
