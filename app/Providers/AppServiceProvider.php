<?php

namespace App\Providers;

use App\Models\Location;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['admin.layouts.header', 'admin.layouts.aside'], function ($view) {
            if (Auth::check()) {
               $admin = Auth::user();
            } elseif (Cookie::get('remember_token')) {
                $remember_token = json_decode(Cookie::get('remember_token'));
                $admin = User::find($remember_token->id);
            }
            $view->with('admin', $admin);
            $locations_for_sidebar = Location::all();
            $view->with('locations_for_sidebar', $locations_for_sidebar);
            $header_languages = Language::all();
            $view->with('header_languages', $header_languages);
            if (Session::get('locale')) {
                $current_language = Language::find(Session::get('locale'));
            } else {
                $current_language = Language::where('name', 'Tiếng Việt')->where('short', 'vi')->first();
            }
            $view->with('current_language', $current_language);
        });
    }
}
