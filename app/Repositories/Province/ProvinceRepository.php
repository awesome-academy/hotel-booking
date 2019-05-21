<?php

namespace App\Repositories\Province;

use App\Models\Province;
use App\Repositories\EloquentRepository;

class ProvinceRepository extends EloquentRepository
{
    public function getModel()
    {
        return Province::class;
    }
}
