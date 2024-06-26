<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Category_contentsTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'category_id' => '1',
            'content_id' => '1',
        ];
        DB::table('category_contents')->insert($param);
        $param = [
            'category_id' => '1',
            'content_id' => '2',
        ];
        DB::table('category_contents')->insert($param);
        $param = [
            'category_id' => '2',
            'content_id' => '3',
        ];
        DB::table('category_contents')->insert($param);
        $param = [
            'category_id' => '2',
            'content_id' => '4',
        ];
        DB::table('category_contents')->insert($param);
        $param = [
            'category_id' => '3',
            'content_id' => '5',
        ];
        DB::table('category_contents')->insert($param);
        $param = [
            'category_id' => '3',
            'content_id' => '6',
        ];
        DB::table('category_contents')->insert($param);
        $param = [
            'category_id' => '4',
            'content_id' => '7',
        ];
        DB::table('category_contents')->insert($param);
        $param = [
            'category_id' => '4',
            'content_id' => '8',
        ];
        DB::table('category_contents')->insert($param);
        $param = [
            'category_id' => '4',
            'content_id' => '9',
        ];
        DB::table('category_contents')->insert($param);
    }
}
