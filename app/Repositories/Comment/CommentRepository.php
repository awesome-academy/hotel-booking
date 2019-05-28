<?php

namespace App\Repositories\Comment;

use App\Models\Comment;
use App\Repositories\EloquentRepository;

class CommentRepository extends EloquentRepository
{
    public function getModel()
    {
        return Comment::class;
    }
}
