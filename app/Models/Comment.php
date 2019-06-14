<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'object',
        'object_id',
        'email',
        'body',
        'rating',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'object_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'object_id');
    }
}
