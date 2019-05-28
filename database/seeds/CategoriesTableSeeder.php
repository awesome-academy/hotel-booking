<?php

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Language;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = new Category();
        $category->name = 'Đồ uống';
        $category->parent_id = 0;
        $category->lang_id = Language::where('short', config('app.locale'))->first()['id'];
        $category->lang_parent_id = 0;
        $category->lang_map = 1;
        $category->save();

    }
}
