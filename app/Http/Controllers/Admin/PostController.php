<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\StorePost;
use App\Http\Requests\Admin\UpdatePost;
use App\Repositories\Post\PostRepository;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Repositories\Language\LanguageRepository;
use App\Repositories\Category\CategoryRepository;
use App\Models\Post;
use Session;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function __construct(PostRepository $postRepository, CategoryRepository $cateRepository, LanguageRepository $langRepository)
    {
        $this->postRepository = $postRepository;
        $this->cateRepository = $cateRepository;
        $this->langRepository = $langRepository;
    }

    public function index()
    {
        $languages = $this->langRepository->all();
        $categories = $this->cateRepository->whereall('lang_id', Session::get('locale'));
        foreach ($categories as $key => $value) {
            if ($value['parent_id'] == 0) {
                unset($categories[$key]);
            }
        }
        $check_unique = $this->langRepository->wherewhere('short', 'vi', 'id', Session::get('locale'));
        $posts = $this->postRepository->all();

        return view('admin.posts.post', compact('posts', 'categories', 'languages', 'check_unique')); 
    }

    public function anyway()
    {
        if (Session::has('locale')) {
            $locale = Session::get('locale');
        }
        $posts = $this->postRepository->whereall('lang_id', $locale);
        foreach ($posts as $key => $value) {
            $parent = $this->cateRepository->find($value['cate_id']);
            if (is_null($parent)) {
                return response()->json(['error' => __('messages.Notfound')]);
            }
            $posts[$key]['name_parent'] = $parent['name'];
        }

        return Datatables::of($posts) 
        ->addColumn('action', function($post) {
            $vi_id = $this->langRepository->whereFirst('short', 'vi');
            if (is_null($vi_id)) {
                return response()->json(['error' => __('messages.Notfound')]);
            }
            if (Session::get('locale') == $vi_id['id']) {
                return '<button class="btn btn-sm btn-info" post_id="' . $post->id . '" data-toggle="modal" data-target="#ShowPost" title="' . __('messages.Show Post') . '" id="showPost"><i class="fas fa-eye"></i></button> <button class="btn btn-sm btn-success" post_id="' . $post->id . '" data-toggle="modal" data-target="#TransPost" id="transPost" lang_id="' . $post->lang_id . '"><i class="fas fa-language"></i></button> <button class="btn btn-sm btn-warning" post_id="' . $post->id . '" data-toggle="modal" data-target="#EditPost" title="' . __('messages.Edit Post') . '" id="editPost"><i class="fas fa-edit"></i></button> <button class="btn btn-sm btn-danger" post_id="' . $post->id . '"  id="deletePost"><i class="far fa-trash-alt"></i></button>';
            } else {
                return ' <button class="btn btn-sm btn-success" post_id="' . $post->lang_parent_id . '" data-toggle="modal" data-target="#TransPost" id="transPost" lang_id="' . $post->lang_id . '"><i class="fas fa-language"></i></button> <button class="btn btn-sm btn-warning" post_id="' . $post->id . '" data-toggle="modal" data-target="#EditPost" title="' . __('messages.Edit Post') . '" id="editPost"><i class="fas fa-edit"></i></button> <button class="btn btn-sm btn-danger" post_id="' . $post->id . '"  id="deletePost"><i class="far fa-trash-alt"></i></button>';
            } 
        })
        ->addColumn('parent_name', function($post) {

            return $post['name_parent'];
        })
        ->editColumn('image', function($post) {
            $url = asset('') . config('upload.default') . $post->image;

            return '<img src="' . $url . '" alt="" class="anyway_image">';
        })
        ->rawColumns(['action', 'name_parent', 'image'])
        ->toJson();
    }

    public function store(StorePost $request)
    {
        $data = $request->all();   
        $data['lang_parent_id'] = 0;
        $lang = $this->langRepository->whereFirst('short', config('language.short'));
        if (is_null($lang)) {
            return response()->json(['error' => __('messages.Notfound')]);;
        }
        $data['lang_id'] = $lang['id'];
        if ($request->hasFile('file')) {
            $data['image'] = uploadImage(config('upload.default'), $request->file);
        }
        DB::beginTransaction();
        try {
            $post = $this->postRepository->create($data);
            $langMap = $post['id'];
            $this->postRepository->update($post['id'], ['lang_map' => $langMap]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }

        return response()->json(['success' => __('messages.Add Successfully'), 'error' => false]);
    }

    public function edit($id)
    {
        $post = $this->postRepository->find($id);
        if (is_null($post)) {            
            return response()->json(['error' => __('messages.Notfound')]);
        }
        $category = $this->cateRepository->find($post['cate_id']);
        if (is_null($category)) {
            return response()->json(['error' => __('messages.Notfound')]);
        }
        $post['cate_name'] = $category['name'];
        $post['image'] = asset(config('upload.default')) . '/' . $post['image'];

        return $post;
    }

    public function update(UpdatePost $request)
    {
        $data = $request->all();
        $post = $this->postRepository->find($data['post_id']);
        if (is_null($post)) {
            return response()->json(['error' => __('messages.Notfound')]);;
        }
        if ($request->hasFile('file')) {
            $data['image'] = uploadImage(config('upload.default'), $request->file);
        } else {
            $data['image'] = $post['image'];
        }
        $posts = $this->postRepository->whereall('lang_map', $post['lang_map']);
        $post_id = $posts->pluck('id')->toArray();
        DB::beginTransaction();
        try {
            $array = array('image' => $data['image']);
            Post::whereIn('id', $post_id)->update($array);
            $this->postRepository->update($data['post_id'], $data);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }

        return response()->json(['success' => __('messages.Update Successfully'), 'error' => false]);
    }

    public function trans(StorePost $request) {
        $data = $request->all();
        $check_unique = $this->postRepository->wherewhere('lang_id', $request->lang_id, 'lang_parent_id', $request->lang_parent_id);
        if (count($check_unique) <= 0) {
            $post = $this->postRepository->find($request->lang_parent_id);
            if (is_null($post)) {
                return response()->json(['error' => __('messages.Notfound')]);;
            }
            $data['image'] = $post['image'];
            $cate = $this->cateRepository->find($post['cate_id']);
            if (is_null($cate)) {
                return response()->json(['error' => __('messages.Notfound')]);;
            }
            $post_cate = $this->cateRepository->wherewhere('lang_map', $cate['lang_map'], 'lang_id', $request->lang_id);
            if (count($post_cate) <=0 ) {
                return response()->json(['error' => __('messages.Notfound')]);
            } else {
                $data['cate_id'] = $post_cate[0]['id'];
            }
            DB::beginTransaction();
            try {
                $newpost = $this->postRepository->create($data);
                $langMap = $post['lang_map'] . ',' . $newpost['id'];
                $this->postRepository->update($newpost['id'], ['lang_map' => $langMap]);
                $postMap = $this->postRepository->pluck('lang_map', $post['lang_map'], 'id');
                $this->postRepository->whereIn('id', $postMap)->update(['lang_map' => $langMap]);

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                throw new Exception($e->getMessage());
            }

            return response()->json(['success' => __('messages.Add Successfully'), 'error' => false]);
        } else {
            return response()->json(['error' => __('messages.Validate_unique')]);
        }
    }

    public function destroy($id)
    {
        $vi_id = $this->langRepository->whereFirst('short', 'vi');
        if (is_null($vi_id)) {
            return response()->json(['error' => __('messages.Notfound')]);;
        }
        if ((int)Session::get('locale') !== $vi_id['id']) {
            $this->postRepository->lang_map($id);
            $this->postRepository->delete($id);
        } else {
            $post = $this->postRepository->find($id);
            if (is_null($post)) {
                return response()->json(['error' => __('messages.Notfound')]);
            }
            $this->postRepository->whereDelete('lang_map', $post['lang_map']);
        }
    }
}
