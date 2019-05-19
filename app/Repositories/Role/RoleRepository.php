<?php

namespace App\Repositories\Role;

use App\Models\Role;
use App\Repositories\EloquentRepository;

class RoleRepository extends EloquentRepository
{
    public function getModel()
    {
        return Role::class;
    }
}
