<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteMenuRequest extends FormRequest
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
       $validation_array = [
                            'link_type' => 'required',
                            'parent'=>'required',
                            'title' => 'required',
                            'location'=>'required',
                            'status'=>'required',
                            'category' => 'nullable',
                            'sub_category' => 'nullable',
                            'topic' => 'nullable',
                            'external_url'=>'nullable'
                           ];
       if($this->has('link_type')){
            $link_type = $this->input('link_type');
            if($link_type == 'internal_link' || $link_type == 'page' || $link_type == 'room'){
                $validation_array = [
                            'link_type' => 'required',
                            'parent'=>'required',
                            'title' => 'required',
                            'location'=>'required',
                            'status'=>'required',
                            'category' => 'nullable',
                            'sub_category' => 'nullable',
                            'topic' => 'required',
                            'external_url'=>'nullable'
                           ];

            }elseif($link_type == 'external_url'){
                $validation_array = [
                            'link_type' => 'required',
                            'parent'=>'required',
                            'title' => 'required',
                            'location'=>'required',
                            'status'=>'required',
                            'category' => 'nullable',
                            'sub_category' => 'nullable',
                            'topic' => 'nullable',
                            'external_url'=>'required'
                           ];
            }
       }     

       return $validation_array;
    }
}
