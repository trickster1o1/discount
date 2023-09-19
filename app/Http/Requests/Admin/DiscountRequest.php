<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DiscountRequest extends FormRequest
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
            'value'=>'required',
            'type'=>'required',
            'product_id'=>'required',
            'status'=>'required',
            'created_by'=>'nullable',
            'updated_by'=>'nullable',
        ];
    }
}
