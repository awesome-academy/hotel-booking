<?php

use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vietnam = new Language();
        $vietnam->frag = 'vietnam.png';
        $vietnam->name = 'Việt Nam';
        $vietnam->short = 'vi';
        $vietnam->save();

        $english = new Language();
        $english->frag = 'england.png';
        $english->name = 'English';
        $english->short = 'en';
        $english->save();
    }
}
