<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'cate_id',
        'title',
        'description',
        'body',
        'lang_id',
        'lang_parent_id',
        'lang_map',
        'image',
    ];

    public function language()
    {
        $this->belongsTo(Language::class, 'lang_id');
    }

    public function comments()
    {
        $this->hasMany(Comment::class, 'object_id');
    }

    public function category()
    {
        $this->belongsTo(Category::class, 'cate_id');
    }
}
