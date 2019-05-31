<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'subject',
        'email',
        'text',
        'location_id',
        'id',
    ];
}
