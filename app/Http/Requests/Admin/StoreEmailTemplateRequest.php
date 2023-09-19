<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmailTemplateRequest extends FormRequest
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
            'template_name' => 'nullable',
            'user_subject' => 'nullable',
            'custom_email' => 'nullable',
            'user_message' => 'nullable',
            'admin_subject' => 'nullable',
            'admin_message' => 'nullable',
            'status' => 'nullable'
        ];
    }
}
