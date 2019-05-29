<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class WebSettingRequest extends FormRequest
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
            'logo' => 'nullable|mimes:jpg,jpeg,png|max:2000',
        ];
    }

    public function messages()
    {
        return [
            'logo.mimes' => __('messages.Validate_mimes_image'),
            'logo.max' => __('messages.Validate_file_mb'),
        ];
    }
}
