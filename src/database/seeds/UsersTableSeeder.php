<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attributes = ['id' => 1];
        $values = ['id' => 1, 'name' => 'Tester', 'email' => 'test@test.com', 'password' => bcrypt('test123'), 'api_token' => 'Ae3oLySV5XNQPd3lO4Dk6x7g4IaGHGpt41KhQRFNu615GYopJSHU0sB6HPui',];

        DB::table('users')->updateOrInsert($attributes, $values);
    }
}
