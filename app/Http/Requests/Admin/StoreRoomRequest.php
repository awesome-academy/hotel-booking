<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
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
            'image' => 'required|mimes:jpg,jpeg,png|max:2000',
            'name' => 'required|max:191',
            'list_room_number' => 'required',
            'price' => 'required|numeric|min:1000',
            'sale_price' => 'nullable|lt:price|numeric',
            'sale_start_at' => 'nullable|after:yesterday',
            'sale_end_at' => 'nullable|after_or_equal:sale_start_at',
            'short_description' => 'required',
            'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'image.required' => __('messages.Validate_required'),
            'image.mimes' => __('messages.Validate_mimes_image'),
            'image.max' => __('messages.Validate_file_mb'),
            'name.required' => __('messages.Validate_required'),
            'name.max' => __('messages.Validate_max') . ' :max ' . __('messages.Validate_character'),
            'list_room_number.required' => __('messages.Validate_required'),
            'price.required' =>  __('messages.Validate_required'),
            'price.numeric' => __('messages.Validate_numeric'),
            'price.min' =>  __('messages.Validate_min') . ' :min ' . __('messages.Validate_character'),
            'sale_price.numeric' => __('messages.Validate_numeric'),
        ];
    }
}
