<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\Admin\UpdateUserRequest;
use App\Repositories\Language\LanguageRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct(UserRepository $userRepository, LanguageRepository $languageRepository)
    {
        $this->userRepository = $userRepository;
        $this->languageRepository = $languageRepository;
        $this->base_lang_id = $languageRepository->getBaseId();
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
}
