<?php

namespace App\Http\Requests\Admin;

use App\Rules\UniqueSlug;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSubCategoryRequest extends FormRequest
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
            'title' =>  ['required', new UniqueSlug],
            'slug' => ['required', new UniqueSlug],
            'status' => 'nullable',
            'tag_line' => 'nullable',
            'category_type' => 'nullable',
            'category' => 'nullable',
            'short_description' => 'nullable',
            'thumb_image' => 'nullable',
            'banner_image' => 'nullable',
            'featured_image' => 'nullable',
            'description' => 'nullable',
            'meta_key' => 'nullable',
            'meta_description' => 'nullable',
            'fb_title' => 'nullable',
            'fb_image' => 'nullable',
            'fb_description' => 'nullable',
            'twitter_image' => 'nullable',
            'twitter_title' => 'nullable',
            'twitter_description' => 'nullable'
        ];
    }
}
