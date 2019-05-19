<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'email' => 'required|email|max:191|unique:users',
            'full_name' => 'required|max:191',
            'password' => 'required|min:6|max:15|confirmed',
            'password_confirmation' => 'required',
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
            'password.required' => __('messages.Validate_required'),
            'password.min' => __('messages.Validate_min') . ' :min ' . __('messages.Validate_character'),
            'password.max' => __('messages.Validate_max') . ' :max ' . __('messages.Validate_character'),
            'password.confirmed' => __('messages.Validate_password_confirm'),
            'password_confirmation.required' => __('messages.Validate_required'),
            'phone.numeric' => __('messages.Validate_numeric'),
            'phone.digits_between' => __('messages.Validate_digits_between') .' :min -' . ' :max' . __('messages.Validate_character'),
            'address.max' => __('messages.Validate_max') . ' :max ' . __('messages.Validate_character'),
        ];
    }
}
