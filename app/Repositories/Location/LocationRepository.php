<?php

namespace App\Repositories\Location;

use App\Models\Location;
use App\Repositories\EloquentRepository;

class LocationRepository extends EloquentRepository
{
    public function getModel()
    {
        return Location::class;
    }
}
