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
            ['id' => 6],
            ['id' => 7],
            ['id' => 8],
            ['id' => 9],
            ['id' => 10],
        ];
        $values = [
            ['user_id' => 1, 'format_id' => 1, 'title' => 'The Shawshank Redemption', 'length' => 142, 'year' => 1994, 'rating' => 5],
            ['user_id' => 1, 'format_id' => 2, 'title' => 'The Godfather', 'length' => 175, 'year' => 1972, 'rating' => 5],
            ['user_id' => 1, 'format_id' => 2, 'title' => 'The Godfather: Part II', 'length' => 202, 'year' => 1974, 'rating' => 5],
            ['user_id' => 1, 'format_id' => 3, 'title' => 'The Dark Knight', 'length' => 152, 'year' => 2008, 'rating' => 4],
            ['user_id' => 1, 'format_id' => 3, 'title' => '12 Angry Men', 'length' => 96, 'year' => 1957, 'rating' => 4],
            ['user_id' => 1, 'format_id' => 1, 'title' => 'Schindler\'s List ', 'length' => 195, 'year' => 1993, 'rating' => 5],
            ['user_id' => 1, 'format_id' => 1, 'title' => 'Pulp Fiction', 'length' => 154, 'year' => 1994, 'rating' => 5],
            ['user_id' => 1, 'format_id' => 2, 'title' => 'The Lord of the Rings: The Return of the King', 'length' => 201, 'year' => 2003, 'rating' => 5],
            ['user_id' => 1, 'format_id' => 3, 'title' => 'The Good, the Bad and the Ugly', 'length' => 161, 'year' => 2008, 'rating' => 4],
            ['user_id' => 1, 'format_id' => 3, 'title' => 'Fight Club', 'length' => 179, 'year' => 1999, 'rating' => 3],
        ];

        foreach ($attributes_array as $attributes) {
            DB::table('movies')->updateOrInsert($attributes, $values[$attributes['id']-1]);
        }

    }
}
