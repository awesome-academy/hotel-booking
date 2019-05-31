<?php

namespace App\Providers;

use App\Models\Language;
use App\Models\Location;
use App\Models\User;
use App\Models\Province;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
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
        /**
         * Admin
         */
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
                if (is_null($current_language)) {
                    $current_language = Language::where('name', Config::get('language.name'))->where('short', Config::get('language.short'))->first();
                }
            } else {
                $current_language = Language::where('name', Config::get('language.name'))->where('short', Config::get('language.short'))->first();
            }
            $view->with('current_language', $current_language);
        });

        /**
         * Client
         */
        View::composer(['client.layouts.header', 'client.layouts.slider', 'client.layouts.sidebar_rooms', 'client.booking.index'], function ($view) {
            $header_languages = Language::all();
            $view->with('header_languages', $header_languages);
            $locations_for_nav = Location::all();
            $view->with('locations_for_nav', $locations_for_nav);
            if (Session::get('locale')) {
                $current_language = Language::find(Session::get('locale'));
                if (is_null($current_language)) {
                    $current_language = Language::where('name', Config::get('language.name'))->where('short', Config::get('language.short'))->first();
                }
            } else {
                $current_language = Language::where('name', Config::get('language.name'))->where('short', Config::get('language.short'))->first();
            }
            $view->with('current_language', $current_language);
            if (Auth::check()) {
                $user = Auth::user();
                $view->with('user', $user);
            } elseif (Cookie::get('remember_token')) {
                $remember_token = json_decode(Cookie::get('remember_token'));
                $user = User::find($remember_token->id);
                $view->with('user', $user);
            }
            $provinces = Province::all();
            if (count($provinces) <= 0) {
                abort('404');
            }
            foreach ($provinces as $key => $value) {
                $location_s = $value->locations()->where('province_id', $value->id)->get();
                if (count($location_s) <= 0) {
                    unset($provinces[$key]);
                } else {
                    $provinces[$key]['pro_loca'] = $location_s;
                }
            }
            $view->with('provinces', $provinces);
        });
    }
}
