<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'object_id',
        'email',
        'body',
    ];

    public function post()
    {
        $this->belongsTo(Post::class, 'object_id');
    }

    public function roomDetail()
    {
        $this->belongsTo(RoomDetail::class, 'object_id');
    }
}
