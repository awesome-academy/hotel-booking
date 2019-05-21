<?php

namespace App\Http\Controllers;

use App\Repositories\Language\LanguageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    public function change($id)
    {
        Session::put('locale', $id);

        return redirect()->back();
    }
}
