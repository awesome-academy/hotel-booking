<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->email = 'admin@gmail.com';
        $user->full_name = 'Admin';
        $user->password = bcrypt('12345678');
        $user->role_id = '1';
        $user->remember_token = md5(uniqid());
        $user->save();
    }
}
