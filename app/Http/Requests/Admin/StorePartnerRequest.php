<?php

namespace App\Http\Requests\Admin;

use App\Rules\UniqueSlug;
use Illuminate\Foundation\Http\FormRequest;

class StorePartnerRequest extends FormRequest
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
            'business_email' => 'required|email',
            'country' => 'required',
            'phone_number' => 'nullable',
            'website_url' => 'nullable|url',
            'latitude' => 'numeric',
            'longitude' => 'numeric',
            'address_details' => 'nullable',
            'thumb_image' => 'nullable',
            'featured_image' => 'nullable',
            'pan_number' => 'nullable|numeric',
            'pan_document' => 'nullable',
            'company_registration_number' => 'nullable',
            'company_registration_date' => 'nullable',
            'company_registration_document' => 'nullable',
            'agreement_paper_copy' => 'nullable',
            'tag_line' => 'nullable',
            'short_description' => 'nullable',
            'full_description' => 'nullable',
            'vat_detail' => 'nullable',
            'vat_percentage' => 'numeric|min:0|max:100',
            'preferred_currency' => 'nullable',
            'address_detail' => 'nullable',
            'meta_key' => 'nullable',
            'meta_description' => 'nullable',
            'fb_title' => 'nullable',
            'fb_description' => 'nullable',
            'fb_image' => 'nullable',
            'twitter_title' => 'nullable',
            'twitter_description' => 'nullable',
            'twitter_image' => 'nullable',
            'status' => 'nullable'
        ];
    }
}
