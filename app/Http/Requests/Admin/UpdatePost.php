<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePost extends FormRequest
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
            'title' => 'required',
            'description' => 'required',
            'body' => 'required',
            'cate_id' => 'required',
        ];
    }
    public function messages(){
        
        return [
            'title.required' => __('messages.validate_title'),
            'description.required' => __('messages.validate_description'),
            'body.required' => __('messages.validate_body'),
            'cate_id.required' => __('messages.validate_cate'),
        ];
    }
}
