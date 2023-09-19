<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VolunteerRequest extends FormRequest
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
            'fullName'=>'required',
            'number'=>'required|numeric',
            'email'=>'required|email',
            'address'=>'required',
            'dob'=>'nullable',
            'occupation'=>'nullable',
            'image'=>'nullable',
            'attachment'=>'nullable',
            'status'=>'required',
        ];
    }
}
