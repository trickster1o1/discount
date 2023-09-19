<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user->id,
            'phone' => 'required|numeric|digits:10|unique:users,phone,' . $this->user->id,
            'username' => 'required|min:6|max:255|unique:users,username,' . $this->user->id,
            'password' => 'exclude_unless:changePassword,on|' . password_rules(),
            'password_confirmation' => 'exclude_unless:changePassword,on|' . password_confirmation_rules(),
            'role_id' => 'required|in:' . roles()->pluck('id')->implode(','),
            'status' => 'nullable|' . status_rules(),
        ];
    }

    public function attributes()
    {
        return [
            'role_id' => 'role'
        ];
    }
}
