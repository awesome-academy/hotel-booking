<?php

namespace App\Http\Controllers\Admin;

use App\Models\Property;
use App\Repositories\Language\LanguageRepository;
use App\Repositories\Property\PropertyRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PropertyController extends Controller
{
    public function __construct(PropertyRepository $propertyRepository, LanguageRepository $languageRepository)
    {
        $this->propertyRepository = $propertyRepository;
        $this->lang_base_id = $languageRepository->getBaseId();
    }

    public function index()
    {
        $base_lang_id = $this->lang_base_id;
        if (Session::has('locale')) {
            if (isset($_GET['keyword'])) {
                $properties = $this->propertyRepository->searchByLang('name', $_GET['keyword'], Config::get('pagination.default'), Session::get('locale'));
            } else {
                $properties = $this->propertyRepository->paginateByLang(Session::get('locale'), Config::get('pagination.default'));
            }
        } else {
            if (isset($_GET['keyword'])) {
                $properties = $this->propertyRepository->searchByLang('name', $_GET['keyword'], Config::get('pagination.default'), $this->lang_base_id);
            } else {
                $properties = $this->propertyRepository->paginateByLang($this->lang_base_id, Config::get('pagination.default'));
            }
        }
        $parent = new Property();
        $data = compact(
            'properties',
            'parent',
            'base_lang_id'
        );

        return view('admin.properties.index', $data);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['lang_id'] = $this->lang_base_id;
        $data['lang_parent_id'] = 0;
        $rules = array(
            'name' => [
                'required',
                'max:191',
                'unique' => Rule::unique('properties')->where('lang_id', $this->lang_base_id),
            ],
        );
        $messages = array(
            'name.required' => __('messages.Validate_required'),
            'name.max' => __('messages.Validate_max') . ' :max ' . __('messages.Validate_character'),
            'name.unique' => __('messages.Validate_unique'),
        );
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return redirect(route('admin.properties.index'))->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try {
            $property = $this->propertyRepository->create($data);
            $dataLangMap = array(
                'lang_map' => $property->id,
            );
            $this->propertyRepository->update($property->id, $dataLangMap);
            DB::commit();
            $request->session()->flash('notification', 'store');

            return redirect(route('admin.properties.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        if (Session::has('locale')) {
            $lang_id = Session::get('locale');
        } else {
            $lang_id = $this->lang_base_id;
        }
        $rules = array(
            'name' => [
                'required',
                'max:191',
                'unique' => Rule::unique('properties')->where('lang_id', $lang_id)->ignore($id),
            ],
        );
        $messages = array(
            'name.required' => __('messages.Validate_required'),
            'name.max' => __('messages.Validate_max') . ' :max ' . __('messages.Validate_character'),
            'name.unique' => __('messages.Validate_unique'),
        );
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['messages' => 'error', 'errors' => $validator->messages()], 200);
        }
        $property = $this->propertyRepository->update($id, $data);

        return response()->json(['messages' => 'success', 'data' => $property], 200);
    }

    public function translate(Request $request, $lang_parent_id)
    {
        $property = $this->propertyRepository->find($lang_parent_id);
        if (is_null($property)) {
            abort(404);
        }
        $languages = $this->propertyRepository->getLanguage($lang_parent_id);
        if (count($languages) == 0) {
            $request->session()->flash('notification', 'full_lang');

            return redirect()->back();
        }
        $data = compact(
            'languages',
            'property'
        );

        return view('admin.properties.translate', $data);
    }

    public function translateStore(Request $request, $lang_parent_id)
    {
        $data = $request->all();
        $rules = array(
            'name' => [
                'required',
                'max:191',
                Rule::unique('properties')->where('lang_id', $data['lang_id']),
            ],
        );
        $messages = array(
            'name.required' => __('messages.Validate_required'),
            'name.max' => __('messages.Validate_max') . ' :max ' . __('messages.Validate_character'),
            'name.unique' => __('messages.Validate_unique'),
        );
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $lang_map_arr = $this->propertyRepository->getLangMap($lang_parent_id);
        DB::beginTransaction();
        try {
            $new_property = $this->propertyRepository->create($data);
            array_push($lang_map_arr, $new_property->id);
            $this->propertyRepository->updateLangMap($lang_parent_id, $lang_map_arr);
            DB::commit();
            $request->session()->flash('notification', 'store');
            Session::put('locale', $data['lang_id']);

            return redirect(route('admin.properties.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function delete(Request $request, $id)
    {
        $delete = $this->propertyRepository->deleteProperty($id);
        if ($delete) {
            $request->session()->flash('notification', 'delete');

        } else {
            $request->session()->flash('notification', 'errors_delete');
        }

        return redirect()->back();
    }
}
