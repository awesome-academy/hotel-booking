<?php

namespace App\Repositories\User;

use App\Models\Role;
use App\Models\User;
use App\Repositories\EloquentRepository;
use Illuminate\Support\Facades\Auth;

class UserRepository extends EloquentRepository
{
    public function getModel()
    {
        return User::class;
    }

    public function checkAdmin($role_id)
    {
        $admin = Role::where('name', 'admin')->first();
        if ($admin->id == $role_id) {
            return true;
        } else {
            return false;
        }
    }

    public function getUser()
    {
        if (Auth::check()) {
            $user = Auth::user();
        } elseif (Cookie::get('remember_token')) {
            $remember_token = json_decode(Cookie::get('remember_token'));
            $user = User::find($remember_token->id);
        }

        return $user;
    }

}
