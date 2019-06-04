<?php 

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App;
use Session;
use App\Repositories\Post\PostRepository;
use App\Http\Controllers\Controller;
use App\Repositories\Language\LanguageRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Comment\CommentRepository;
use App\Http\Requests\Client\StoreComment;

class PostController extends Controller
{
    public function __construct(PostRepository $postRepo, LanguageRepository $langRepository, CategoryRepository $cateRepository, CommentRepository $commentRepo) {
        $this->postRepo = $postRepo;
        $this->langRepository = $langRepository;
        $this->cateRepository = $cateRepository;
        $this->commentRepo = $commentRepo;
    }

    public function index($cate_id)
    {
        $vi_id = $this->langRepository->whereFirst('short', 'vi');
        if (is_null($vi_id)) {
            abort('404');
        }
        $lag_id = Session::get('locale');
        $category = $this->cateRepository->find($cate_id);
        if (is_null($category)) {
            abort('404');
        }
        if ( $category['lang_id'] == $lag_id) {
            $posts = $this->postRepo->paginateByLangCate($lag_id, env('PAGES'), $cate_id);
        } else {
            $cate = $this->cateRepository->wherewhere('lang_map', $category['lang_map'], 'lang_id', $lag_id);
            if (count($cate) <= 0) {
                abort('404');
            }
            $posts = $this->postRepo->paginateByLangCate($lag_id, env('PAGES'), $cate[0]['id']);
        }
        foreach ($posts as $key => $value) {
            $posts[$key]['image'] = asset('') . config('upload.default') . $value['image'];
            if ($lag_id == $vi_id['id']) {
                $posts[$key]['date'] = $value->created_at->format('d/m/Y');
            } else {
                $posts[$key]['date'] = $value->created_at->format('Y M d');
            }
                $posts[$key]['cate_name'] = $category['name'];
                $allcomments = $this->commentRepo->wherewhere('object', 'post', 'object_id', $value['id']);
        }
        $new_posts = $this->postRepo->whereall('lang_id', Session::get('locale'))->take(config('post.default'));
        foreach ($new_posts as $key => $value) {
            $new_posts[$key]['image'] = asset('') . config('upload.default') . $value['image'];
        }

        return view('client.blog.blog', compact('posts', 'new_posts', 'allcomments'));
    }

    public function category()
    {
        $cates = $this->cateRepository->whereall('lang_id', Session::get('locale'));
        if (count($cates) <= 0) {
            abort('404');
        } else {
            foreach ($cates as $key => $value) {
                if ($value['parent_id'] == 0) {
                    $cate_child = $this->cateRepository->whereall('parent_id', $value['id']);
                    if (count($cate_child) <= 0) {
                        unset($cates[$key]);
                    } else {
                        foreach ($cate_child as $key1 => $value1) {
                            $post = $this->postRepo->whereall('cate_id', $value1['id']);
                            if (count($post) <= 0 ) {
                                unset($cate_child[$key1]);
                            } else {
                                $cates[$key]['image'] = asset('') . config('upload.default') . $post[0]['image'];
                            }
                        }
                    }
                } else {
                    unset($cates[$key]);
                }
            }

            return view('client.blog.blog_category', compact('cates', 'cate_child'));
        }
    }

    public function detail($id)
    {
        if (session('locale')) {
            $post = $this->postRepo->whereFirst('lang_id', session('locale'));
        }
        if (is_null($post)) {
            abort('404');
        }
        $post['image'] = asset('') . config('upload.default') . $post['image'];
        $vi_id = $this->langRepository->whereFirst('short', 'vi');
        if (is_null($vi_id)) {
            abort('404');
        }
        $lag_id = Session::get('locale');
        $allcomments = $this->commentRepo->wherewhere('object', 'post', 'object_id', $id);
        $comments = $this->commentRepo->takeByComment($id);
        if ($lag_id == $vi_id['id']) {
            $post['date'] = $post->created_at->format('d/m/Y');
        } else {
            $post['date'] = $post->created_at->format('Y M d');
        }
        $category = $this->cateRepository->find($post['cate_id']);
        if (is_null($category)) {
            abort('404');
        }
        $post['cate_name'] = $category['name'];
        $new_posts = $this->postRepo->whereall('lang_id', Session::get('locale'))->take(config('post.default'));
        foreach ($new_posts as $key => $value) {
            $new_posts[$key]['image'] = asset('') . config('upload.default') . $value['image'];
        }
        foreach ($comments as $key => $value) {
            $comments[$key]['date'] = $value->created_at->format('Y M d');
        }

        return view('client.blog.blogDetail', compact('post', 'new_posts', 'comments', 'allcomments'));
    }

    public function comment(StoreComment $request)
    {
        $input = $request->all();
        $input['object'] = 'post';
        $input['body'] = $input['text'];
        $comment_send = $this->commentRepo->create($input);
        $comment_send['date'] = $comment_send->created_at->format('Y M d');
        $comment_send['number'] = count($this->commentRepo->all());

        return response()->json(['data' => $comment_send, 'error' => false]);
    }

    public function more($id)
    {
        $comments = $this->commentRepo->skipByComment($id);

        return $comments;
    }
}
