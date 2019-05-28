<?php

namespace App\Repositories\Post;

use App\Models\Post;
use App\Repositories\EloquentRepository;

class PostRepository extends EloquentRepository
{
    public function getModel()
    {
        return Post::class;
    }
}
