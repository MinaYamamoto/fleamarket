<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContentsTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'レディース',
        ];
        DB::table('contents')->insert($param);
        $param = [
            'name' => 'メンズ',
        ];
        DB::table('contents')->insert($param);
        $param = [
            'name' => 'ベビー服',
        ];
        DB::table('contents')->insert($param);
        $param = [
            'name' => '子供服',
        ];
        DB::table('contents')->insert($param);
        $param = [
            'name' => 'テレビゲーム',
        ];
        DB::table('contents')->insert($param);
        $param = [
            'name' => 'パズル',
        ];
        DB::table('contents')->insert($param);
        $param = [
            'name' => '楽器',
        ];
        DB::table('contents')->insert($param);
        $param = [
            'name' => 'プラモデル',
        ];
        DB::table('contents')->insert($param);
        $param = [
            'name' => 'アート用品',
        ];
        DB::table('contents')->insert($param);
    }
}
