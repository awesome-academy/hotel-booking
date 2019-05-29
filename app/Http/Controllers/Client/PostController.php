<?php 

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App;
use Session;
use App\Repositories\Post\PostRepository;
use App\Http\Controllers\Controller;
use App\Repositories\Language\LanguageRepository;
use App\Repositories\Category\CategoryRepository;

class PostController extends Controller
{
    public function __construct(PostRepository $postRepo, LanguageRepository $langRepository, CategoryRepository $cateRepository) {
        $this->postRepo = $postRepo;
        $this->langRepository = $langRepository;
        $this->cateRepository = $cateRepository;
    }

    public function index($cate_id) {
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }
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
        if (count($posts) <= 0) {
            abort('404');
        }
        foreach ($posts as $key => $value) {
            $posts[$key]['image'] = asset('') . config('upload.default') . $value['image'];
            if ($lag_id == $vi_id['id']) {
                $posts[$key]['date'] = $value->created_at->format('d/m/Y');
            } else {
                $posts[$key]['date'] = $value->created_at->format('Y M d');
            }
                $posts[$key]['cate_name'] = $category['name'];
        }
        $new_posts = $this->postRepo->whereall('lang_id', Session::get('locale'))->take(config('post.default'));
        foreach ($new_posts as $key => $value) {
            $new_posts[$key]['image'] = asset('') . config('upload.default') . $value['image'];
        }

        return view('client.blog.blog', compact('posts', 'new_posts'));
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
                    foreach ($cate_child as $key1 => $value1) {
                        $post = $this->postRepo->whereall('cate_id', $value1['id']);
                        if (count($post) <= 0 ) {
                            unset($cate_child[$key1]);
                        } else {
                            $cates[$key]['image'] = asset('') . config('upload.default') . $post[0]['image'];
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
        $post = $this->postRepo->find($id);
        if (is_null($post)) {
            abort('404');
        }
        $post['image'] = asset('') . config('upload.default') . $post['image'];
        $vi_id = $this->langRepository->whereFirst('short', 'vi');
        if (is_null($vi_id)) {
            abort('404');
        }
        $lag_id = Session::get('locale');
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
        
        return view('client.blog.blogDetail', compact('post', 'new_posts'));
    }
}
