<?php

namespace App\Http\Requests\Admin;

use App\Rules\UniqueSlug;
use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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
            'slug' => ['required', new UniqueSlug],
            'category' => 'required',
            'sub_category' => 'nullable',
            'thumb_image' => 'nullable',
            'featured_image' => 'nullable',
            'banner_image'=>'nullable',
            'is_featured' => 'nullable',
            'status' => 'nullable',
            'order_by' => 'nullable',
            'gallery_id' => 'nullable',
            'attached_file_url' => 'nullable',
            'start_date' => 'nullable',
            'end_date' => 'nullable',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'location' => 'nullable',
            'short_description' => 'nullable',
            'descrption' => 'nullable',
            'meta_key' => 'nullable',
            'meta_description' => 'nullable',
            'fb_title' => 'nullable',
            'fb_description' => 'nullable',
            'fb_image' => 'nullable',
            'twitter_title' => 'nullable',
            'twitter_description' => 'nullable',
            'twitter_image' => 'nullable',
        ];
    }
}
