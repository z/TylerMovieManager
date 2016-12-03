<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormatsTableSeeder extends Seeder
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
        ];
        $values = [
            ['name' => 'VHS'],
            ['name' => 'DVD'],
            ['name' => 'Streaming'],
        ];

        foreach ($attributes_array as $attributes) {
            DB::table('formats')->updateOrInsert($attributes, $values[$attributes['id']-1]);
        }
    }
}
