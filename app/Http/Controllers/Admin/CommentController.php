<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\Comment\CommentRepository;
use App\Repositories\Post\PostRepository;
use App\Repositories\RoomDetail\RoomDetailRepository;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function __construct(CommentRepository $commentRepo, PostRepository $postRepo, RoomDetailRepository $roomRepo)
    {
        $this->commentRepo = $commentRepo;
        $this->postRepo = $postRepo;
        $this->roomRepo = $roomRepo;
    }
    
    public function index($object)
    {
        if ($object == 'post') {
            return view('admin.comment.commentpost', compact('object'));
        } else {
            return view('admin.comment.commentroom', compact('object'));
        }
    }

    public function anyway($object)
    {   
        $comments = $this->commentRepo->whereall('object', $object);
        foreach ($comments as $key => $value) {
            if ($object == 'post') {
                $post = $this->postRepo->find($value['object_id']);
                if (!empty($post)) {
                    $comments[$key]['object_id'] = $post['title'];
                }
            
            } else {
                $room = $this->roomRepo->whereFirst('room_id', $value['object_id']);
                if (!empty($room)) {
                    $comments[$key]['object_id'] = $room['name'];
                }
            
            }
        }

        return Datatables::of($comments)
        ->addColumn('action', function($comment) {
 
            return '<button class="btn btn-sm btn-danger" comment_id="' . $comment->id . '" data-toggle="modal" id="deleteComment"><i class="far fa-trash-alt"></i></button>';
        })
        ->editColumn('object_id', function($comment) {

            return '<p class="truncate2">' . $comment['object_id'] . '</p>';
        })
        ->editColumn('body', function($comment) {

            return '<p class="truncate2">' . $comment['body'] . '</p>';
        })
        ->editColumn('rating', function($comment) {
            $html = '';
            for ($i=1; $i <= $comment['rating']; $i++) { 
                $html = $html . '<li><i class="fa fa-star"></i></li>';
            }
            return '<div class="comment-rating"><ul>' . $html . '</ul></div>';
        })
        ->rawColumns(['action', 'body', 'object_id', 'rating'])
        ->toJson();
    }

    public function delete($id)
    {
        $comment = $this->commentRepo->find($id);
        if (is_null($comment)) {
            abort('404');
        }
        $this->commentRepo->delete($id);

        return response()->json(['object' => $comment['object']]);
    }
}
