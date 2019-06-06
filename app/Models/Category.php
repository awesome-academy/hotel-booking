<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'parent_id',
        'lang_id',
        'lang_parent_id',
        'lang_map',
        'id',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'lang_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'cate_id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

}
