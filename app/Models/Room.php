<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'location_id',
        'image',
        'sale_status',
        'sale_start_at',
        'sale_end_at',
        'list_room_number',
        'rating',
        'available_time',
    ];

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'room_property');
    }

    public function locations()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function roomDetails()
    {
        return $this->hasMany(RoomDetail::class, 'room_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'room_invoice', 'room_id', 'invoice_code');
    }
}
