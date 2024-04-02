<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConditionsTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => '新品、未使用',
        ];
        DB::table('conditions')->insert($param);
        $param = [
            'name' => '未使用に近い',
        ];
        DB::table('conditions')->insert($param);
        $param = [
            'name' => '目立った傷や汚れなし',
        ];
        DB::table('conditions')->insert($param);
        $param = [
            'name' => 'やや傷や汚れあり',
        ];
        DB::table('conditions')->insert($param);
        $param = [
            'name' => '傷や汚れあり',
        ];
        DB::table('conditions')->insert($param);
        $param = [
            'name' => '全体的に状態が悪い',
        ];
        DB::table('conditions')->insert($param);
    }
}
