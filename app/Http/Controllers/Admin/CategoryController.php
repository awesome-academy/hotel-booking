<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreCategory;
use App\Http\Requests\Admin\UpdateCategory;
use App\Repositories\Category\CategoryRepository;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Repositories\Language\LanguageRepository;
use Session;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Repositories\Post\PostRepository;
use App\Models\Post;

class CategoryController extends Controller
{

    public function __construct(CategoryRepository $cateRepository, LanguageRepository $langRepository, PostRepository $postRepository)
    {
        $this->cateRepository = $cateRepository;
        $this->langRepository = $langRepository;
        $this->postRepository = $postRepository;
    }

    public function index()
    {
        if (Session::has('locale')) {
            $locale = Session::get('locale');
        }
        $check_unique = $this->langRepository->wherewhere('short', 'vi', 'id', $locale);
        $languages = $this->langRepository->all();
        if (count($languages) > 0) {
            $categories = $this->cateRepository->category($locale);

            return view('admin.categories.category', compact('categories', 'languages', 'check_unique'));
        } 
    }

    public function anyway()
    {
        if (Session::has('locale')) {
            $locale = Session::get('locale');
        }
        $language = $this->langRepository->find($locale);
        if (is_null($language)) {
            return response()->json(['error' => __('messages.NotfoundLanguage')]);;
        }
        $categories = $this->cateRepository->whereall('lang_id', $language['id']);
        foreach ($categories as $key => $category) {
            if ($category['parent_id'] == 0) {
                $categories[$key]['name_parent'] = __('messages.No parent_name');
            } else {
                $parent = $this->cateRepository->find($category['parent_id']);
                if (is_null($parent)) {
                    return response()->json(['error' => __('messages.NotfoundCategory')]);
                }
                $categories[$key]['name_parent'] = $parent['name'];
            }
        }

        return Datatables::of($categories) 
        ->addColumn('action', function($category) {
            $vi_id = $this->langRepository->whereFirst('short', 'vi');
            if (is_null($vi_id)) {
                return response()->json(['error' => __('messages.NotfoundLanguage')]);;
            }
            if (Session::get('locale') == $vi_id['id']) {
                return ' <button class="btn btn-sm btn-success" category_id="' . $category->id . '" data-toggle="modal" data-target="#TransCate" id="transCate" lang_id="' . $category->lang_id . '"><i class="fas fa-language"></i></button> <button class="btn btn-sm btn-warning" category_id="' . $category->id . '" data-toggle="modal" data-target="#EditCategory" title="' . __('messages.Edit Category') . '" id="editCategory"><i class="fas fa-edit"></i></button> <button class="btn btn-sm btn-danger" category_id="' . $category->id . '" data-toggle="modal" id="deleteCate"><i class="far fa-trash-alt"></i></button>';
            } else {
                return ' <button class="btn btn-sm btn-success" category_id="' . $category->lang_parent_id . '" data-toggle="modal" data-target="#TransCate" id="transCate" lang_id="' . $category->lang_id . '"><i class="fas fa-language"></i></button> <button class="btn btn-sm btn-warning" category_id="' . $category->id . '" data-toggle="modal" data-target="#EditCategory" title="' . __('messages.Edit Category') . '" id="editCategory"><i class="fas fa-edit"></i></button> <button class="btn btn-sm btn-danger" category_id="' . $category->id . '" data-toggle="modal" id="deleteCate"><i class="far fa-trash-alt"></i></button>';
            }
        })
        ->addColumn('parent_name', function($category) {

            return $category['name_parent'];
        })
        ->rawColumns(['action', 'name_parent'])
        ->toJson();
    }

    public function store(StoreCategory $request)
    {
        $data = $request->all();
        $error = null;
        $check_unique = $this->cateRepository->wherewhere('lang_id', Session::get('locale'), 'name', $request->name);
        if (count($check_unique) <= 0) {
            if ($request->parent_id == 'undefined') {
                $data['parent_id'] = 0;
            }
            $data['lang_parent_id'] = 0;
            $lang = $this->langRepository->whereFirst('short', config('language.short'));
            if (!empty($lang)) {
                $data['lang_id'] = $lang['id'];
                DB::beginTransaction();
                try {
                    $cate = $this->cateRepository->create($data);
                    $langMap = $cate['id'];
                    $this->cateRepository->update($cate['id'], ['lang_map' => $langMap]);
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollBack();
                    throw new Exception($e->getMessage());
                }
            } else {
                $error = __('messages.NotfoundLanguage');
            }
        } else {
             $error = __('messages.Validate_unique');
        }
        if ($error == null) {
           return response()->json(['success' => __('messages.Add Successfully'), 'error' => false]);
        }

        return response()->json(['errors' => $error]);
    }

    public function edit($id)
    {
        $vi_id = $this->langRepository->whereFirst('short', 'vi');
        $error = null;
        if (!empty($vi_id)) {
            $category = $this->cateRepository->find($id);
            if (!empty($category)) {
                if (Session::has('locale')) {
                    $locale = Session::get('locale');
                }
                if ($locale == $vi_id['id']) {
                    $edit_categories = $this->cateRepository->category($locale);
                    foreach ($edit_categories as $key => $value) {
                        if ($value['id'] == $category['id']) {
                            unset($edit_categories[$key]);
                        }
                        if ($value['id'] == $category['parent_id'] && $category['parent_id'] !== 0) {
                            unset($edit_categories[$key]);
                        }
                    }
                    $cate_child = $this->cateRepository->whereall('parent_id', $id);
                    $category['edit_categories'] = $edit_categories;
                    $category['count'] = count($cate_child);
                } else {
                    $category['count'] = 'en';
                }
            } else {
                $error = __('messages.NotfoundCategory');
            }
        } else {
            $error =  __('messages.NotfoundLanguage');
        }
        if ($error == null) {
           return  $category;
        }

        return response()->json(['errors' => $error]);
    }

    public function update(UpdateCategory $request)
    {
        $data = $request->all();
        $error = null;
        $check_unique = $this->cateRepository->wherewhere('lang_id', Session::get('locale'), 'name', $request->name);
        $category = $this->cateRepository->find($data['id']);
        if (!empty($category)) {
            if ((count($check_unique) <= 0) || isset($request->parent_id)) {
                $cates = $this->cateRepository->whereall('lang_map', $category['lang_map']);
                DB::beginTransaction();
                try {
                    if (!isset($request->parent_id)) {
                        $this->cateRepository->find($category['id'])->update(['name' => $data['name']]);
                    } else {
                        $this->cateRepository->find($category['id'])->update(['name' => $data['name'], 'parent_id' => $data['parent_id']]);
                        foreach ($cates as $key => $value) {
                            if ($value['id'] == $data['id']) {
                                unset($cates[$key]);
                            } else {
                                $cate_parent = $this->cateRepository->wherewhere('lang_parent_id', $data['parent_id'], 'lang_id', $value['lang_id']);
                                $language = $this->langRepository->whereFirst('id', $value['lang_id']);
                                if (!empty($language)) {
                                    if (count($cate_parent) > 0) {
                                        $this->cateRepository->update($value['id'],['parent_id' => $cate_parent[0]['id']]);
                                    } else {
                                        $error = __('messages.NotfoundCategory' . 'ParentLanguage ') . $language['name'];
                                    }
                                } else {
                                    $error = __('messages.NotfoundLanguage');
                                }
                            }
                        }
                    }
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollBack();
                    throw new Exception($e->getMessage());
                }
            } else {
                $error = __('messages.Validate_unique');
            }
        } else {
            $error = __('messages.NotfoundCategory');
        }
        if ($error == null) {
            return response()->json(['success' => __('messages.Update Successfully'), 'error' => false]);
        }
        return response()->json(['errors' => $error]);
    }

    public function trans(StoreCategory $request) {
        $data = $request->all();
        $error = null;
        $check_unique = $this->cateRepository->wherewhere('lang_id', $request->lang_id, 'lang_parent_id', $request->lang_parent_id);
        $vi_id = $this->langRepository->whereFirst('short', 'vi');
        if (!empty($vi_id)) { 
            if (count($check_unique) <= 0) {
                if ((int)$request->lang_id !== $vi_id['id']) {
                    $category = $this->cateRepository->find($request->lang_parent_id);
                    if (!empty($category)) {
                        if ($category['parent_id'] == 0) {
                            $data['parent_id'] = 0;
                            DB::beginTransaction();
                            try {
                                $newcate = $this->cateRepository->create($data);
                                $langMap = $category['lang_map'] . ',' . $newcate['id'];
                                $this->cateRepository->update($newcate['id'], ['lang_map' => $langMap]);
                                $cates = $this->cateRepository->pluck('lang_map', $category['lang_map'], 'id');
                                $this->cateRepository->whereIn('id', $cates)->update(['lang_map' => $langMap]);
                                DB::commit();
                            } catch (Exception $e) {
                                DB::rollBack();
                                throw new Exception($e->getMessage());
                            }
                        } else {
                            $category2 = $this->cateRepository->wherewhere('lang_parent_id', $category['parent_id'], 'lang_id', $request->lang_id);
                            if (count($category2) > 0) {                   
                                $data['parent_id'] = $category2[0]['id'];
                                DB::beginTransaction();
                                try {
                                    $newcate = $this->cateRepository->create($data);
                                    $langMap = $category['lang_map'] . ',' . $newcate['id'];
                                    $this->cateRepository->update($newcate['id'], ['lang_map' => $langMap]);
                                    $cates = $this->cateRepository->pluck('lang_map', $category['lang_map'], 'id');
                                    $this->cateRepository->whereIn('id', $cates)->update(['lang_map' => $langMap]);
                                    DB::commit();
                                } catch (Exception $e) {
                                    DB::rollBack();
                                    throw new Exception($e->getMessage());
                                }
                            } else {
                                $error = __('messages.NotfoundCategoryParentLanguage ') . $data['lang_name'];
                            }
                        }
                    } else {
                        $error = __('messages.NotfoundCategory');
                    }
                } else {
                    $error = __('messages.Validate_unique');
                }
            } else {
                $error = __('messages.Validate_unique');
            }
        } else {
            $error = __('messages.NotfoundLanguage');
        }
        if ($error == null) {
            return response()->json(['success' => __('messages.Add Successfully'), 'error' => false]);
        }
        return response()->json(['errors' => $error]);
    }
    public function destroy($id)
    {
        $vi_id = $this->langRepository->whereFirst('short', 'vi');
        $error = null;
        if (!empty($vi_id)) {   
            $cate = $this->cateRepository->find($id);
            if (!empty($cate)) {
                if ((int)Session::get('locale') !== $vi_id['id']) {
                    if ($cate['parent_id'] == 0) {
                        DB::beginTransaction();
                        try {
                            $cate_id = $this->cateRepository->pluck('parent_id', $id, 'id');
                            foreach ($cate_id as $key => $value) {
                                $this->postRepository->whereDelete('cate_id', $cate_id);
                                $this->cateRepository->delete($value);
                            }
                            $this->cateRepository->delete($id);
                            $this->postRepository->whereDelete('cate_id', $id);
                            DB::commit();
                        } catch (Exception $e) {
                            DB::rollBack();
                            throw new Exception($e->getMessage());
                        }
                    } else {
                        DB::beginTransaction();
                        try {
                            $this->cateRepository->lang_map($id);
                            $this->cateRepository->delete($id);
                            $this->postRepository->wheredelete('cate_id', $id);
                            DB::commit();
                        } catch (Exception $e) {
                            DB::rollBack();
                            throw new Exception($e->getMessage());
                        }
                    }
                } else {
                    if ($cate['parent_id'] == 0) {
                        DB::beginTransaction();
                        try {
                            $child_cate = $this->cateRepository->whereall('parent_id', $cate['id']);
                            if (count($child_cate) <= 0) {
                                $this->cateRepository->delete($id);
                            } else {
                                foreach ($child_cate as $key => $value) {
                                    $cate_id = $this->cateRepository->pluck('lang_map', $value['lang_map'], 'id');
                                    foreach ($cate_id as $key1 => $value1) {
                                        $this->postRepository->whereDelete('cate_id', $value1);
                                        $this->cateRepository->delete($value1);
                                    }
                                }
                                $this->postRepository->wheredelete('cate_id', $id);
                                $this->cateRepository->whereDelete('lang_map', $cate['lang_map']);
                                DB::commit();
                            }
                        } catch (Exception $e) {
                            DB::rollBack();
                            throw new Exception($e->getMessage());
                        }
                    } else {
                        DB::beginTransaction();
                        try {
                            $cate_id = $this->cateRepository->pluck('lang_map', $cate['lang_map'], 'id');
                            foreach ($cate_id as $key => $value) {
                                $this->postRepository->whereDelete('cate_id', $value);
                                $this->cateRepository->delete($value);
                            }
                            DB::commit();
                        } catch (Exception $e) {
                            DB::rollBack();
                            throw new Exception($e->getMessage());
                        }
                    }
                }
            } else {
                $error = __('messages.NotfoundCategory');
            }
        } else {
            $error = __('messages.NotfoundLanguage');
        }
        if ($error !== null) {
            return response()->json(['errors' => $error]); 
        }
    }
}
