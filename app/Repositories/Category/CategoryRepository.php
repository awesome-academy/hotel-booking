<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Repositories\EloquentRepository;

class CategoryRepository extends EloquentRepository
{
    public function getModel()
    {
        return Category::class;
    }

    public function category($locale)
    {
    	$categories = $this->_model->where('lang_id', $locale)->get();
        foreach ($categories as $key => $value) {
            if ($value['parent_id'] !== 0) {
                unset($categories[$key]);
            }
        }

        return $categories;
    }
}
