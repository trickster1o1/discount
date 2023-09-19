<?php

namespace App\Http\Requests\Admin;

use App\Rules\UniqueSlug;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePopupRequest extends FormRequest
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
            'popup_description' => 'required',
            'start_date' => 'required',
            'start_time' => 'nullable',
            'end_date' => 'nullable',
            'end_time' => 'nullable',
            'order_by' => 'nullable',
            'status' => 'nullable'
        ];
    }
}
