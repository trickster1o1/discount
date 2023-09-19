<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiteSettingRequest extends FormRequest
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
            'email' => 'required',
            'pri_phone' => 'nullable',
            'pri_email' => 'nullable|email',
            'pri_address' => 'nullable',
            'sec_phone' => 'nullable',
            'sec_email' => 'nullable',
            'sec_address' => 'nullable',
            'email_verification' => 'nullable',
            'primary_logo' => 'nullable',
            'secondary_logo' => 'nullable',
            'url' => 'nullable',
            'offline_msg' => 'nullable',
            'fb_link' => 'nullable',
            'youtube_link' => 'nullable',
            'twitter_link' => 'nullable',
            'ig_link' => 'nullable',
            'linkedin_link' => 'nullable',
            'viber' => 'nullable',
            'pintrest_link' => 'nullable',
            'skype_link' => 'nullable',
            'facebook_page_id' => 'nullable',
            'android' => 'nullable',
            'ios' => 'nullable',
            'meta_key' => 'nullable',
            'meta_description' => 'nullable',
            'fb_title' => 'nullable',
            'fb_image' => 'nullable',
            'fb_description' => 'nullable',
            'twitter_title' => 'nullable',
            'twitter_description' => 'nullable',
            'twitter_image' => 'nullable',
            'status' => 'nullable',
            'google_map_html'=>'nullable',
            'loader'=>'nullable'
        ];
    }
}
