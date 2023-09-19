<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAlbumRequest extends FormRequest
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
            'title' => 'required',
            'slug' => 'required',
            'status' => 'nullable',
            'tagline' => 'nullable',
            'thumb_image' => 'nullable',
            'banner_image' => 'nullable',
            'album_description' => 'nullable',
            'album_short_description' => 'nullable',
            'meta_key' => 'nullable',
            'meta_description' => 'nullable',
            'fb_title' => 'nullable',
            'fb_image' => 'nullable',
            'fb_description' => 'nullable',
            'twitter_image' => 'nullable',
            'twitter_title' => 'nullable',
            'twitter_description' => 'nullable',
        ];
    }
}
