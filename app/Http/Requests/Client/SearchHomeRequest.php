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
            'check_in' => 'required',
            'check_out' => 'required',
            'location' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'check_in.required' => __('messages.Validate_required'),
            'check_out.required' => __('messages.Validate_required'),
            'location.required' => __('messages.Validate_required'),
        ];
    }
}
