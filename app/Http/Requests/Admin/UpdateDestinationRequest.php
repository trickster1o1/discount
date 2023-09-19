<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDestinationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'country' => 'required',
            'city' => 'required',
            'latitude' => 'required|numeric',
            'tag_line' => 'nullable',
            'thumb_image' => 'nullable',
            'banner_image' => 'nullable',
            'status' => 'required',
            'short_description' => 'nullable',
            'description' => 'nullable',
            'longitude' => 'required|numeric',
            'meta_key' => 'nullable',
            'meta_description' => 'nullable',
            'fb_title' => 'nullable',
            'fb_description' => 'nullable',
            'fb_image' => 'nullable',
            'twitter_title' => 'nullable',
            'twitter_description' => 'nullable',
            'twitter_image' => 'nullable',
            'rating' => 'nullable',
            'album_id' => 'nullable'
        ];
    }
}
