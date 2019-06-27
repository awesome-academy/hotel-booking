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

    public function getRoleId($role_name)
    {
        $role = Role::where('name', $role_name)->first();
        if (is_null($role)) {
            return false;
        }
        $id = $role->id;

        return $id;
    }

    public function userNotifi($id)
    {
        $user = User::where('role_id', 1)->get();
        
        return $user;
    }
}
