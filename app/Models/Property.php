<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'name',
        'lang_id',
        'lang_parent_id',
        'lang_map',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'lang_id');
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'room_property');
    }
}
