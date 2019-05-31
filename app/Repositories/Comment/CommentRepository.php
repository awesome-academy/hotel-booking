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

    public function takeByComment($post_id)
    {
        return $this->_model->where('object', 'post')->where('object_id', $post_id)->orderBy('id', 'desc')->take(env('COMMENT_PAGES'))->get();
    }

    public function skipByComment($post_id)
    {
        return $this->_model->where('object', 'post')->where('object_id', $post_id)->orderBy('id', 'desc')->skip(env('COMMENT_PAGES'))->take(env('COMMENT_ALL'))->get();
    }
}
