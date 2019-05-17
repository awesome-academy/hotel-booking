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
            'email.required' => 'Vui lòng nhập Email',
            'email.email' => 'Vui lòng nhập đúng định dạng Email',
            'email.max' => 'Vui lòng không nhập quá 191 ký tự',
            'email.unique' => 'Email này đã được sử dụng',
            'full_name.required' => 'Vui lòng nhập đầy đủ họ và tên',
            'full_name.max' => 'Vui lòng không nhập quá 191 ký tự',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu cần tối thiểu 6 ký tự',
            'password.max' => 'Mật khẩu chi được chứa tối đa 15 ký tự',
            'password.confirmed' => 'Mật khẩu nhập lại không khớp',
            'password_confirmation.required' => 'Vui lòng nhập lại mật khẩu',
            'phone.numeric' => 'Vui lòng chỉ nhập số',
            'phone.digits_between' => 'Chỉ được nhập từ 9 tới 13 số',
            'address.max' => 'Vui lòng không nhập quá 191 ký tự',
        ];
    }
}
