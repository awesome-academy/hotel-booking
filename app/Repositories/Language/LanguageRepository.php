<?php

namespace App\Repositories\Language;

use App\Models\Language;
use App\Repositories\EloquentRepository;

class LanguageRepository extends EloquentRepository
{
    public function getModel()
    {
        return Language::class;
    }
}
