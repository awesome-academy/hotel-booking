<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
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
            'customer_name' => 'required|max:191',
            'customer_email' => 'required|email|max:191',
            'customer_phone' => 'required|numeric|digits_between:9,13',
            'customer_address' => 'required|max:191',
        ];
    }

    public function messages()
    {
        return [
            'customer_name.required' => __('messages.Validate_required'),
            'customer_name.max' => __('messages.Validate_max') . ' :max ' . __('messages.Validate_character'),
            'customer_email.required' => __('messages.Validate_required'),
            'customer_phone.required' => __('messages.Validate_required'),
            'customer_address.required' => __('messages.Validate_required'),
            'customer_email.email' => __('messages.Validate_email'),
            'customer_email.max' => __('messages.Validate_max') . ' :max ' . __('messages.Validate_character'),
            'customer_address.max' => __('messages.Validate_max') . ' :max ' . __('messages.Validate_character'),
            'customer_phone.digits_between' => __('messages.Validate_digits_between') . ' :min -' . ' :max' . __('messages.Validate_character'),
            'customer_phone.numeric' => __('messages.Validate_numeric'),
        ];
    }
}
