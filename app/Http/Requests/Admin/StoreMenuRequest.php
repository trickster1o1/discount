<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenuRequest extends FormRequest
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
            'route' => 'nullable|max:255',
            'parent' => 'nullable|integer|in:' . parent_menus()->pluck('id')->push(0)->implode(','),
            'menu_code' => 'nullable',
            'position' => 'nullable',
            'icon_class' => 'nullable',
            'status' => 'required|' . status_rules(),
            'is_module'=>'required'
        ];
    }
}
