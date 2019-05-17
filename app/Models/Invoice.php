<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'code',
        'user_id',
        'customer_email',
        'customer_name',
        'customer_phone',
        'customer_address',
        'messages',
        'total',
    ];

    public function rooms()
    {
        $this->belongsToMany(Room::class)->withPivot('room_id', 'invoice_code', 'room_number', 'price', 'check_in_date', 'check_out_date');
    }

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
