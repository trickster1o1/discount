<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            //
            'title'=>'required',
            'slug'=>'required',
            'category'=>'required',
            'sub_category'=>'required',
            'thumb_image'=>'nullable',
            'featured_image'=>'nullable',
            'is_featured'=>'nullable',
            'status'=>'required',
            'gallery_id'=>'nullable',
            'attached_file_url'=>'nullable',
            'start_date'=>'nullable',
            'start_time'=>'nullable',
            'end_date'=>'nullable',
            'end_time'=>'nullable',
            'location'=>'nullable',
            'description'=>'nullable',
            'short_description'=>'nullable',
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
