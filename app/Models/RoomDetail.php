<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomDetail extends Model
{
    protected $fillable = [
        'room_id',
        'name',
        'short_description',
        'description',
        'lang_id',
        'lang_parent_id',
        'lang_map',
    ];

    public function language()
    {
        $this->belongsTo(Language::class, 'lang_id');
    }

    public function room()
    {
        $this->belongsTo(Room::class, 'room_id');
    }

    public function comments()
    {
        $this->hasMany(Comment::class, 'object_id');
    }
}
