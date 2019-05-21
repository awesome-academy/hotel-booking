<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() || $request->cookie('remember_token')) {
            if (Auth::check()) {
                $user = Auth::user();
            } elseif ($request->cookie('remember_token')) {
                $remember_token = json_decode(Cookie::get('remember_token'));
                $user = User::find($remember_token->id);
                if (is_null($user)) {
                    return redirect(route('client.login'));
                }
            }
            if ($user->role_id == User::getRoleId('member')) {
                return redirect(route('client.index'));
            }
        } else {
            return redirect(route('client.login'));
        }

        return $next($request);
    }
}
