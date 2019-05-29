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
        return $this->belongsToMany(Room::class, 'room_invoice', 'invoice_code', 'code');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
