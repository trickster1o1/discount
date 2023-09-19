<?php

namespace App\Http\Requests\Admin;

use App\Rules\UniqueSlug;
use Illuminate\Foundation\Http\FormRequest;

class ProductAddRequest extends FormRequest
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
          'title'=>'required',
          'slug' => ['required', new UniqueSlug],
          'status' => 'nullable',
          'category' => 'required',
          'price' => 'required|numeric',
          'short_description' => 'nullable',
          'thumb_image' => 'required',
          'featured_image' => 'nullable',
          'imga' => 'nullable',
          'imgb' => 'nullable',
          'imgc' => 'nullable',
          'imgd' => 'nullable',
          'description' => 'required',
          'tags' => 'nullable',
          'meta_key' => 'nullable',
          'meta_description' => 'nullable',
          'fb_title' => 'nullable',
          'fb_image' => 'nullable',
          'fb_description' => 'nullable',
          'twitter_image' => 'nullable',
          'twitter_title' => 'nullable',
          'twitter_description' => 'nullable',
          'is_featured'=>'nullable',
        ];
    }
}
