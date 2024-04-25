<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => '2',
            'category_content_id' => '1',
            'condition_id' => '1',
            'name' => 'テスト商品登録',
            'brand_name' => 'テストブランド名',
            'explanation' => 'テスト商品の説明',
            'price' => '10000',
            'image' => '/storage/jewellery.jpg'
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => '2',
            'category_content_id' => '2',
            'condition_id' => '2',
            'name' => 'TestItem',
            'brand_name' => '',
            'explanation' => 'TestItemの説明',
            'price' => '5000',
            'image' => '/storage/shoes.jpg'
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => '2',
            'category_content_id' => '2',
            'condition_id' => '6',
            'name' => 'チェス',
            'brand_name' => '',
            'explanation' => 'チェス'."\n".'商品説明登録'."\n".'改行あり',
            'price' => '20000',
            'image' => '/storage/checkmate-1511866_1280.jpg'
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => '3',
            'category_content_id' => '6',
            'condition_id' => '3',
            'name' => 'パズル',
            'brand_name' => 'NoBrand',
            'explanation' => '商品説明登録',
            'price' => '900',
            'image' => '/storage/puzzle-3223941_1280.jpg'
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => '2',
            'category_content_id' => '7',
            'condition_id' => '4',
            'name' => 'チェス（テレビゲーム）',
            'brand_name' => '',
            'explanation' => 'チェス'."\n".'テレビゲーム'."\n".'商品説明',
            'price' => '6000',
            'image' => '/storage/checkmate-1511866_1280.jpg'
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => '2',
            'category_content_id' => '4',
            'condition_id' => '1',
            'name' => '子供用靴',
            'brand_name' => 'ABCD',
            'explanation' => '子供用の靴',
            'price' => '3000',
            'image' => '/storage/shoes.jpg'
        ];
        DB::table('items')->insert($param);
    }
}
