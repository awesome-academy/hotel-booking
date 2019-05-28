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

class CategoryController extends Controller
{
    public function __construct(CategoryRepository $cateRepository, LanguageRepository $langRepository)
    {
        $this->cateRepository = $cateRepository;
        $this->langRepository = $langRepository;
    }

    public function index()
    {
        if (Session::has('locale')) {
            $locale = Session::get('locale');
        }
        $check_unique = $this->langRepository->wherewhere('short', 'vi', 'id', $locale);
        $languages = $this->langRepository->all();
        if(count($languages) > 0) {
            $categories = $this->cateRepository->whereall('lang_id', $locale);

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
            abort('404');
        }
        $categories = $this->cateRepository->whereall('lang_id', $language['id']);
        foreach ($categories as $key => $category) {
            if($category['parent_id'] == 0) {
                $categories[$key]['name_parent'] = __('messages.No parent_name');
            } else {
                $parent = $this->cateRepository->find($category['parent_id']);
                if(is_null($parent)) {
                    abort('404');
                }
                $categories[$key]['name_parent'] = $parent['name'];
            }
        }

        return Datatables::of($categories) 
        ->addColumn('action', function($category) {

            return ' <button class="btn btn-sm btn-success" category_id="' . $category->id . '" data-toggle="modal" data-target="#TransCate" id="transCate" lang_id="' . $category->lang_id . '"><i class="fas fa-language"></i></button> <button class="btn btn-sm btn-warning" category_id="' . $category->id . '" data-toggle="modal" data-target="#EditCategory" title="' . __('messages.Edit Category') . '" id="editCategory"><i class="fas fa-edit"></i></button> <button class="btn btn-sm btn-danger" category_id="' . $category->id . '" data-toggle="modal" id="deleteCate"><i class="far fa-trash-alt"></i></button>';
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
        $check_unique = $this->cateRepository->wherewhere('lang_id', Session::get('locale'), 'name', $request->name);
        if(count($check_unique) <= 0) {
            if($request->parent_id == 'undefined') {
                $data['parent_id'] = 0;
            }
            $data['lang_parent_id'] = 0;
            $lang = $this->langRepository->whereFirst('short', config('language.short'));
            if(is_null($lang)) {
                abort('404');
            }
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

            return response()->json(['success' => __('messages.Add Successfully'), 'error' => false]);
        } else {

            return response()->json(['error' => __('messages.Validate_unique')]);
        }
    }

    public function edit($id)
    {
        $category = $this->cateRepository->find($id);
        if (is_null($category)) {
            abort('404');
        }

        return $category;
    }

    public function update(UpdateCategory $request)
    {

        $data = $request->all();
        $category = $this->cateRepository->find($data['id']);
        if (is_null($category)) {
            abort('404');
        }
        $cate = $this->cateRepository->update($data['id'], ['name' => $data['name']]);

        return response()->json(['success' => __('messages.Update Successfully'), 'error' => false]);
    }

    public function trans(StoreCategory $request) {
        $data = $request->all();
        $check_unique = $this->cateRepository->wherewhere('lang_id', $request->lang_id, 'lang_parent_id', $request->lang_parent_id);
        if(count($check_unique) <= 0) {
            $category = $this->cateRepository->find($request->lang_parent_id);
            if (is_null($category)) {
            abort('404');
            }
            if($category['parent_id'] == 0) {
                $data['parent_id'] = 0;
            } else {
            $category2 = $this->cateRepository->wherewhere('lang_parent_id', $category['parent_id'], 'lang_id', $request->lang_id);
            $data['parent_id'] = $category2[0]['id'];
            }
            DB::beginTransaction();
                try {
                    $newcate = $this->cateRepository->create($data);
                    $langMap = $category['lang_map'] . ',' . $newcate['id'];
                    $this->cateRepository->update($newcate['id'], ['lang_map' => $langMap]);
                    $cates = $this->cateRepository->whereall('lang_map', $category['lang_map']);
                    foreach ($cates as $key => $value) {
                        $value->update(['lang_map' => $langMap]);
                    }

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
        $this->cateRepository->delete($id);
        $this->cateRepository->whereDelete('parent_id', $id);
    }
}
