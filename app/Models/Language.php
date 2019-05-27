<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
        'frag',
        'name',
        'short',
    ];

    public function roomDetails()
    {
        return $this->hasMany(RoomDetail::class, 'lang_id');
    }

    public function properties()
    {
        return $this->hasMany(Property::class, 'lang_id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'lang_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'lang_id');
    }
}
