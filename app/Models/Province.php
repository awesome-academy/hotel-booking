<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $fillable = [
        'name',
        'regions',
    ];

    public function locations()
    {
        return $this->hasMany(Location::class, 'province_id');
    }
}
