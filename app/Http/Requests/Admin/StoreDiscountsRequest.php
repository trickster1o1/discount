<?php

namespace App\Http\Requests\admin;

use App\Rules\UniqueSlug;
use Illuminate\Foundation\Http\FormRequest;

class StoreDiscountsRequest extends FormRequest
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
            'discount_category' => 'nullable',
            'discount_type' => 'nullable',
            'status' => 'nullable',
            'discount' => 'nullable',
            'min_cart_value' => 'nullable',
            'discount_start' => 'nullable',
            'discount_end' => 'nullable'
        ];
    }
}
