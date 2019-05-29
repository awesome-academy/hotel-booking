<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePost extends FormRequest
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
            'file' => 'file',
        ];
    }
    public function messages(){
        
        return [
            'title.required' => __('messages.validate_title'),
            'description.required' => __('messages.validate_description'),
            'body.required' => __('messages.validate_body'),
            'file.file' => __('messages.validate_file')
        ];
    }
}
