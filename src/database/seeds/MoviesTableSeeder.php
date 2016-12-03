<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MoviesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attributes_array = [
            ['id' => 1],
            ['id' => 2],
            ['id' => 3],
            ['id' => 4],
            ['id' => 5],
        ];
        $values = [
            ['user_id' => 1, 'format_id' => 1, 'title' => 'The Shawshank Redemption', 'length' => 1000, 'year' => 1994, 'rating' => 5],
            ['user_id' => 1, 'format_id' => 1, 'title' => 'The Godfather', 'length' => 1300, 'year' => 1972, 'rating' => 5],
            ['user_id' => 1, 'format_id' => 1, 'title' => 'The Godfather: Part II', 'length' => 1005, 'year' => 1974, 'rating' => 5],
            ['user_id' => 1, 'format_id' => 1, 'title' => 'The Dark Knight', 'length' => 2300, 'year' => 2008, 'rating' => 4],
            ['user_id' => 1, 'format_id' => 1, 'title' => '12 Angry Men', 'length' => 1200, 'year' => 1957, 'rating' => 4],
        ];

        foreach ($attributes_array as $attributes) {
            DB::table('movies')->updateOrInsert($attributes, $values[$attributes['id']-1]);
        }

    }
}
