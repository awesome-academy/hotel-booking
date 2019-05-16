<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebSetting extends Model
{
    protected $fillable = [
        'logo',
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
        'tripadvisor',
    ];
}
