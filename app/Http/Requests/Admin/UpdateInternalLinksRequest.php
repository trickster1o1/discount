<?php

namespace App\Http\Requests\admin;

use App\Rules\UniqueSlug;
use Illuminate\Foundation\Http\FormRequest;

class UpdateInternalLinksRequest extends FormRequest
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
            'title' => ['required', new UniqueSlug],
            'slug' => 'nullable',
            'tagline' => 'nullable',
            'short_description' => 'nullable',
            'description' => 'nullable',
            'meta_key' => 'nullable',
            'meta_description' => 'nullable',
            'fb_title' => 'nullable',
            'fb_description' => 'nullable',
            'fb_image' => 'nullable',
            'twitter_image' => 'nullable',
            'twitter_description' => 'nullable',
            'twitter_title' => 'nullable',
            'status' => 'nullable',
            'featured_image'=>'nullable',
            'thumb_image'=>'nullable',
            'banner_image'=>'nullable',
        ];
    }
}
