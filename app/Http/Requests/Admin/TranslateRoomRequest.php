<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TranslateRoomRequest extends FormRequest
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
            'name' => 'required|max:191',
            'price' => 'required|numeric|min:1',
            'sale_price' => 'nullable|lt:price|numeric',
            'short_description' => 'required',
            'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('messages.Validate_required'),
            'name.max' => __('messages.Validate_max') . ' :max ' . __('messages.Validate_character'),
            'price.required' => __('messages.Validate_required'),
            'price.numeric' => __('messages.Validate_numeric'),
            'price.min' => __('messages.Validate_min') . ' :min ',
            'short_description.required' => __('messages.Validate_required'),
            'description.required' => __('messages.Validate_required'),
        ];
    }
}
