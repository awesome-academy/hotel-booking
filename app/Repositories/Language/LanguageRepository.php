<?php

namespace App\Repositories\Language;

use App\Models\Language;
use App\Repositories\EloquentRepository;
use Illuminate\Support\Facades\Config;

class LanguageRepository extends EloquentRepository
{
    public function getModel()
    {
        return Language::class;
    }

    public function getBaseId()
    {
        $base = Language::where('name', Config::get('language.name'))->where('short', Config::get('language.short'))->first();
        if (is_null($base)) {
            abort(404);
        }

        return $base->id;
    }
}
