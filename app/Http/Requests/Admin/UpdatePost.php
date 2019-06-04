<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'title' => [
                'required',
                Rule::unique('posts')->ignore($this->post_id),
                ],
            'description' => 'required',
            'body' => 'required',
        ];
    }
    public function messages(){
        
        return [
            'title.required' => __('messages.validate_title'),
            'title.unique' => __('messages.Validate_unique'),
            'description.required' => __('messages.validate_description'),
            'body.required' => __('messages.validate_body'),
        ];
    }
}
