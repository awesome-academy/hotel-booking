<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function form()
    {
        if (Auth::check()) {
            return redirect()->back();
        }

        return view('auth.login');
    }

    public function authenticate(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            if ($request->remember == 'on') {
                $minutes = 50000;
                $cookie_data = [];
                $cookie_data['remember_token'] = $user->remember_token;
                $cookie_data['id'] = $user->id;
                $cookie_data['role_id'] = $user->role_id;
                Cookie::queue(Cookie::make('remember_token', json_encode($cookie_data), $minutes));
            }
            if ($user->role_id == User::getRoleId('member')) {
                return redirect(route('client.index'));
            } else {
                return redirect(route('admin.index'));
            }
        } else {
            $request->session()->flash('login-errors');

            return redirect(route('client.login'));
        }
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        Cookie::queue(Cookie::forget('remember_token'));

        return $this->loggedOut($request) ?: redirect('/');
    }

    public function register(Request $request,UserRepository $userRepository)
    {
        $data = $request->all();
        $rules = array(
            'email' => 'required|email|max:191|unique:users',
            'full_name' => 'required|max:191',
            'password' => 'required|min:6|max:15|confirmed',
            'password_confirmation' => 'required',
            'phone' => 'nullable|numeric|digits_between:9,13',
            'address' => 'nullable|max:191',
        );
        $messages = array(
            'email.required' => __('messages.Validate_email_required'),
            'email.email' => __('messages.Validate_email'),
            'email.max' => __('messages.Validate_max') . ' :max ' . __('messages.Validate_character'),
            'email.unique' => __('messages.Email_unique'),
            'full_name.required' => __('messages.Validate_full_name_required'),
            'full_name.max' => __('messages.Validate_max') . ' :max ' . __('messages.Validate_character'),
            'password.required' => __('messages.Validate_password_required'),
            'password.min' => __('messages.Validate_min') . ' :min ' . __('messages.Validate_character'),
            'password.max' => __('messages.Validate_max') . ' :max ' . __('messages.Validate_character'),
            'password.confirmed' => __('messages.Validate_password_confirm'),
            'password_confirmation.required' => __('messages.Validate_password_confirmation_required'),
            'phone.numeric' => __('messages.Validate_phone_numeric'),
            'phone.digits_between' => __('messages.Validate_digits_between') .' :min -' . ' :max' . __('messages.Validate_character'),
            'address.max' => __('messages.Validate_max') . ' :max ' . __('messages.Validate_character'),
        );
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['messages' => 'validation_fails', 'errors' => $validator->messages()], 200);
        }
        $data['remember_token'] = md5(uniqid());
        $data['password'] = bcrypt($request->password);
        $data['role_id'] = $this->userRepository->getRoleId('member');
        $this->userRepository->create($data);

        return response()->json(['messages' => 'success'], 200);
    }
}
