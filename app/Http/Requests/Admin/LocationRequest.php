<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LocationRequest extends FormRequest
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
            'name' => [
                'required',
                'max:191',
                Rule::unique('locations')->ignore($this->id),
            ],
            'email' => [
                'required',
                'email',
                'max:191',
                Rule::unique('locations')->ignore($this->id),
            ],
            'phone' => [
                'required',
                'numeric',
                'digits_between:9,13',
                Rule::unique('locations')->ignore($this->id),
            ],
            'province_id' => 'required',
            'address' => [
                'required',
                'max:191',
                Rule::unique('locations')->ignore($this->id),
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('messages.Validate_required'),
            'email.required' => __('messages.Validate_required'),
            'email.email' => __('messages.Validate_email'),
            'phone.required' => __('messages.Validate_required'),
            'phone.numeric' => __('messages.Validate_numeric'),
            'phone.digits_between' => __('messages.Validate_digits_between') . ' :min -' . ' :max' . __('messages.Validate_character'),
            'address.required' => __('messages.Validate_required'),
            'name.max' => __('messages.Validate_max') . ' :max ' . __('messages.Validate_character'),
            'email.max' => __('messages.Validate_max') . ' :max ' . __('messages.Validate_character'),
            'address.max' => __('messages.Validate_max') . ' :max ' . __('messages.Validate_character'),
            'name.unique' => __('messages.unique'),
            'phone.unique' => __('messages.unique'),
            'email.unique' => __('messages.unique'),
            'address.unique' => __('messages.unique'),
            'province_id.required' => __('messages.Validate_required'),
        ];
    }
}
