<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DonnerRequest extends FormRequest
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
            'fullName'=>'required|max:20',
            'number'=>'required|numeric',
            'email'=>'required|email',
            'amount'=>'required|numeric',
            'position'=>'nullable|max:20',
            'image'=>'nullable',
            'paymentMethod'=>'required',
            'donationProgram'=>'required',
            'status'=>'required',
        ];
    }
}
