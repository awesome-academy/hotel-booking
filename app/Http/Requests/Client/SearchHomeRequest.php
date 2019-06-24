<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class SearchHomeRequest extends FormRequest
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
            'check_in' => 'required|date|date_format:m/d/Y|after:yesterday',
            'check_out' => 'required|date|date_format:m/d/Y|after:check_in',
            'location' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'check_in.required' => __('messages.Validate_required'),
            'check_in.date' => __('messages.Validate_date'),
            'check_in.date_format' => __('messages.Validate_date_format'),
            'check_in.after' => __('messages.Validate_after_yesterday'),
            'check_out.required' => __('messages.Validate_required'),
            'check_out.date' => __('messages.Validate_date'),
            'check_out.date_format' => __('messages.Validate_date_format'),
            'check_out.after' => __('messages.Validate_after_check_in'),
            'location.required' => __('messages.Validate_required'),
        ];
    }
}
