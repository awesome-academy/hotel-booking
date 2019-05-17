<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Session;

class HomeController extends Controller
{
    public function index() {
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }

        return view('/client/index');
    }
    public function changeLanguage($locale) {
        Session::put('locale', $locale);
        
        return redirect()->back();
    }
}
