<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\Admin\UpdateUserRequest;
use App\Repositories\Invoice\InvoiceRepository;
use App\Repositories\Language\LanguageRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct(UserRepository $userRepository, LanguageRepository $languageRepository, InvoiceRepository $invoiceRepository)
    {
        $this->userRepository = $userRepository;
        $this->languageRepository = $languageRepository;
        $this->base_lang_id = $languageRepository->getBaseId();
        $this->invoiceRepository = $invoiceRepository;
    }

    public function profile($id)
    {
        $base_lang_id = $this->base_lang_id;
        $user = $this->userRepository->find($id);
        if (is_null($user)) {
            abort(404);
        }
        $invoices = $user->invoices()->get();
        $data = compact(
            'user',
            'invoices',
            'base_lang_id'
        );

        return view('client.users.profile', $data);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $data = $request->all();
        $this->userRepository->update($id, $data);
        $request->session()->flash('notification', 'update');

        return redirect()->back();
    }

    public function changePassword(Request $request)
    {
        $data = $request->all();
        $user = $this->userRepository->find($data['id']);
        if (is_null($user)) {
            return response()->json(['errors' => 'user_not_found', 'messages_user_not_found' => __('messages.Validate_cant_found_user')], 200);
        }
        $rules = array(
            'old_password' => 'required',
            'password' => 'required|min:6|max:15|confirmed',
        );
        $messages = array(
            'old_password.required' => __('messages.Validate_old_password_required'),
            'password.required' => __('messages.Validate_password_required'),
            'password.min' => __('messages.Validate_min') . ' :min ' . __('messages.Validate_character'),
            'password.max' => __('messages.Validate_max') . ' :max ' . __('messages.Validate_character'),
            'password.confirmed' => __('messages.Validate_password_confirm'),
        );
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['messages' => 'errors', 'errors' => $validator->messages()], 200);
        }
        if (!Hash::check($data['old_password'], $user->password)) {
            return response()->json(['errors' => 'wrong_old_password', 'messages_old_password' => __('messages.Validate_wrong_old_password')], 200);
        } else {
            $data['password'] = bcrypt($request->password);
            $this->userRepository->update($data['id'], $data);

            return response()->json(['messages' => 'success'], 200);
        }
    }

    public function showInfo($id)
    {
        $invoice = $this->invoiceRepository->find($id);
        if (is_null($invoice)) {
            $data_response = [
                'messages' => 'not_found',
            ];
        } else {
            $data_response = [
                'messages' => 'success',
                'data' => $invoice,
            ];
        }

        return response()->json($data_response, 200);
    }

    public function updateInfo(Request $request)
    {
        $data = $request->all();
        $rules = [
            'customer_name' => 'required|max:191',
            'customer_email' => 'required|email|max:191',
            'customer_phone' => 'required|numeric|digits_between:9,13',
            'customer_address' => 'required|max:191',
        ];
        $messages = [
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
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            $data_response = [
                'messages' => 'Validation_fails',
                'data' => $validator->messages(),
            ];
        } else {
            $invoice = $this->invoiceRepository->find($data['id']);
            if (is_null($invoice)) {
                $data_response = [
                    'messages' => 'not_found',
                ];
            } else {
                $check = $this->invoiceRepository->checkDateForUpdate($invoice);
                if (!$check) {
                    $data_response = [
                        'messages' => 'cant_update',
                    ];
                } else {
                    $new = $this->invoiceRepository->update($data['id'], $data);

                    $data_response = [
                        'messages' => 'success',
                        'data' => $new,
                    ];
                }
            }
        }

        return response()->json($data_response, 200);
    }
}
