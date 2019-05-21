<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreLanguage;
use App\Http\Requests\Admin\UpdateLanguage;
use App\Repositories\Language\LanguageRepository;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;

class LanguageController extends Controller
{
    public function __construct(LanguageRepository $langRepository)
    {
        $this->langRepository = $langRepository;
    }
  
    public function index()
    {
        return view('admin.languages.language');
    }

    public function anyway()
    {
        $languages = $this->langRepository->all();

        return Datatables::of($languages) 
            ->addColumn('action', function ($language) {

                return '<button class="btn btn-sm btn-warning" language_id="' . $language->id . '" data-toggle="modal" data-target="#EditLanguage" title="' . __('messages.Edit Language') . '" id="editLanguage"><i class="fas fa-edit"></i></button>';
        })
            ->editColumn('frag', function ($language) { 
                $url = config('upload.default') . $language->frag;

                return '<img src="' . asset($url) . '" alt="" class="store_img">';
        })
            ->rawColumns(['action', 'frag'])
            ->toJson();
    }

    public function store(StoreLanguage $request)
    {
        $data = $request->all();
        $data['short'] = strtolower(substr($request->name, 0, 2));
        if ($request->hasFile('file')) {
            $data['frag'] = uploadImage(config('upload.default'), $request->file);
        }
        $this->langRepository->create($data);

        return response()->json(['success' => __('messages.Add Successfully'), 'error' => false ]);
    }

    public function edit($id)
    {
        $language = $this->langRepository->find($id);
        if (is_null($language)) {
            abort('404');
        }
        $language['frag'] = config('upload.default') . $language->frag;

        return $language;
    }

    public function update(UpdateLanguage $request)
    {
        $data = $request->all();
        $language = $this->langRepository->find($data['id']);
        if (is_null($language)) {
            abort('404');
        }
        $data['short'] = strtolower(substr($request->name, 0, 2));
        if ($request->file == 'undefine') {
            $data['frag'] = $language['frag'];
        } else if ($request->hasFile('file')) {
            $data['frag'] = uploadImage(config('upload.default'), $request->file);
        }
        $lang = $this->langRepository->update($data['id'], $data);

        return response()->json(['success' => __('messages.Update Successfully'), 'error' => false]);
    }
}
