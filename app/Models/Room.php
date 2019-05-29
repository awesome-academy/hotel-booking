<?php

namespace App\Models;

use Carbon\Carbon;
use http\Env\Request;
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
        return $this->belongsToMany(Invoice::class, 'room_invoice', 'room_id', 'invoice_code' , 'id', 'code')->withPivot('check_in_date', 'check_out_date');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'object_id', 'id');
    }

    public function availableRoomNumber($check_in, $check_out, $room_id)
    {
        $check_in_day = Carbon::parse($check_in);
        $check_out_day = Carbon::parse($check_out);
        $room = Room::find($room_id);
        $room_numbers = [];
        if (is_null($room)) {
            return false;
        }
        $available_times = json_decode($room->available_time, true);
        foreach ($available_times as $available_time) {
            $check_in_available = Carbon::parse($available_time['check_in']);
            $check_out_available = Carbon::parse($available_time['check_out']);
            $between_checkin = $check_in_available->diff($check_in_day);
            $between_checkin_checkout = $check_in_day->diff($check_out_day);
            $between_checkout = $check_out_day->diff($check_out_available);
            if ($between_checkin->invert == 0 && $between_checkin_checkout->days <= $available_time['length'] && $between_checkout->invert == 0) {
               foreach ($available_time['available_rooms'] as $item) {
                   array_push($room_numbers, $item);
               }
            }
        }
        if (!isset($room_numbers)) {
            return false;
        }

        return array_unique($room_numbers);
    }
}
