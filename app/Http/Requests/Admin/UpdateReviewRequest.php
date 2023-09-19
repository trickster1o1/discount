<?php

namespace App\Http\Requests\admin;

use App\Rules\UniqueSlug;
use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
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
            'name' => ['required'],
            'email' => 'required|email',
            'review' => 'nullable',
            'status' => 'nullable',
            'review_rating' => 'nullable',
            'review_for' => 'nullable',
            'review_category' => 'required'
        ];
    }
}
