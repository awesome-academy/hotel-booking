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

    public function roomDetail()
    {
        return $this->belongsTo(RoomDetail::class, 'object_id');
    }
}
