<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'ファッション',
        ];
        DB::table('categories')->insert($param);
        $param = [
            'name' => 'ベビー・キッズ',
        ];
        DB::table('categories')->insert($param);
        $param = [
            'name' => 'ゲーム・おもちゃ',
        ];
        DB::table('categories')->insert($param);
        $param = [
            'name' => 'ホビー・楽器',
        ];
        DB::table('categories')->insert($param);
    }
}
