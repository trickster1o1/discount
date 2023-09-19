<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreHomeSettingRequest extends FormRequest
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
            'slider_status' => 'required',
            'default_banner_image' => 'required',
            'banner_title' => 'nullable',
            'banner_tagline' => 'nullable',
            'banner_link' => 'nullable',
            'banner_button_title' => 'nullable',
            'destination_title' => 'nullable',
            'destination_tagline' => 'nullable',
            'destination_description' => 'nullable',
            'property_title' => 'nullable',
            'property_tagline' => 'nullable',
            'property_description' => 'nullable',
            'tour_title' => 'nullable',
            'tour_tagline' => 'nullable',
            'tour_description' => 'nullable',
            'tm_title' => 'nullable',
            'tm_tagline' => 'nullable'
        ];
    }
}
