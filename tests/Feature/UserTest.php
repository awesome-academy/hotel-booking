<?php

namespace Tests\Feature;

use App\Models\User;
use Faker\Factory;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    public function testCreate()
    {
        $faker = Factory::create();
        $data = [
            'email' => $faker->unique()->email,
            'password' => bcrypt(Str::random(8)),
            'full_name' => $faker->name,
            'phone' => Str::random(10),
            'address' => $faker->address,
            'remember_token' => md5(uniqid()),
            'role_id' => 1,
        ];
        $user = User::create($data);
        $this->assertEquals(1, $this->count($user));
    }

    public function testUpdate()
    {
        $faker = Factory::create();
        $data = [
            'email' => $faker->unique()->email,
            'password' => bcrypt(Str::random(8)),
            'full_name' => $faker->name,
            'phone' => Str::random(10),
            'address' => $faker->address,
            'remember_token' => md5(uniqid()),
            'role_id' => 1,
        ];
        $user = User::create($data);
        $user_updated = $user->update(['full_name' => 'Fullname Updated']);
        $this->assertEquals(true, $user_updated);
    }

    public function testDelete()
    {
        $faker = Factory::create();
        $data = [
            'email' => $faker->unique()->email,
            'password' => bcrypt(Str::random(8)),
            'full_name' => $faker->name,
            'phone' => Str::random(10),
            'address' => $faker->address,
            'remember_token' => md5(uniqid()),
            'role_id' => 1,
        ];
        $user = User::create($data);
        $result = $user->delete($user->id);
        $this->assertEquals(true, $result);
    }
}
