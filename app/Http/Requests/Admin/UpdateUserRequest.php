<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'email' => [
                'required',
                'email',
                'max:191',
                Rule::unique('users')->ignore($this->id),
            ],
            'full_name' => 'required|max:191',
            'phone' => 'nullable|numeric|digits_between:9,13',
            'address' => 'nullable|max:191',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => __('messages.Validate_required'),
            'email.email' => __('messages.Validate_email'),
            'email.max' => __('messages.Validate_max') . ' :max ' . __('messages.Validate_character'),
            'email.unique' => __('messages.unique'),
            'full_name.required' => __('messages.Validate_required'),
            'full_name.max' => __('messages.Validate_max') . ' :max ' . __('messages.Validate_character'),
            'phone.numeric' => __('messages.Validate_numeric'),
            'phone.digits_between' => __('messages.Validate_digits_between') .' :min -' . ' :max' . __('messages.Validate_character'),
            'address.max' => __('messages.Validate_max') . ' :max ' . __('messages.Validate_character'),
        ];
    }
}
