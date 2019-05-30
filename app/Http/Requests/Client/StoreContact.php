<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class StoreContact extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email',
            'text' => 'required',
            'subject' => 'required|max:191',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('messages.Validate_required'),
            'email.required' => __('messages.Validate_required'),
            'email.email' => __('messages.Validate_email'),
            'text.required' => __('messages.Validate_required'),
            'subject.required' => __('messages.Validate_required'),
        ];
    }
}
