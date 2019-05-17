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
        $this->hasMany(RoomDetail::class, 'lang_id');
    }

    public function properties()
    {
        $this->hasMany(Property::class, 'lang_id');
    }

    public function categories()
    {
        $this->hasMany(Category::class, 'lang_id');
    }

    public function posts()
    {
        $this->hasMany(Post::class, 'lang_id');
    }
}
