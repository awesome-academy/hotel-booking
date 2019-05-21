<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $vietnam = Language::where('short', 'vi')->where('name', 'Tiếng Việt')->first();
        if(!Session::has('locale')){
            Session::put('locale', $vietnam->id);
        }
        $language = Language::find(\session('locale'));
        App::setLocale($language->short);
        
        return $next($request);
    }
}
