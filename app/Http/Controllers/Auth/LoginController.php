<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    use AuthenticatesUsers;

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
}
