<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Category_contentsTable extends Seeder
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
    }
}
