<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'province_id',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class, 'location_id');
    }
}
