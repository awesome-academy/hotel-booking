<?php

namespace App\Repositories\WebSetting;

use App\Models\WebSetting;
use App\Repositories\EloquentRepository;

class WebSettingRepository extends EloquentRepository
{
    public function getModel()
    {
        return WebSetting::class;
    }

    public function getData()
    {
        $web = $this->_model->first();

        return $web;
    }
}
