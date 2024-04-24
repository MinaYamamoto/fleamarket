<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeedEc2 extends Seeder
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
            'image' => 'https://fleamarket-bucket.s3.ap-northeast-1.amazonaws.com/jewellery.jpg'
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
            'image' => 'https://fleamarket-bucket.s3.ap-northeast-1.amazonaws.com/shoes.jpg'
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => '2',
            'category_content_id' => '2',
            'condition_id' => '6',
            'name' => 'チェス',
            'brand_name' => '',
            'explanation' => 'チェス
                            商品説明登録
                            改行あり',
            'price' => '20000',
            'image' => 'https://fleamarket-bucket.s3.ap-northeast-1.amazonaws.com/checkmate-1511866_1280.jpg'
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
            'image' => 'https://fleamarket-bucket.s3.ap-northeast-1.amazonaws.com/puzzle-3223941_1280.jpg'
        ];
        DB::table('items')->insert($param);
        $param = [
            'user_id' => '2',
            'category_content_id' => '7',
            'condition_id' => '4',
            'name' => 'チェス（テレビゲーム）',
            'brand_name' => '',
            'explanation' => 'チェス
                            テレビゲーム
                            商品説明',
            'price' => '6000',
            'image' => 'https://fleamarket-bucket.s3.ap-northeast-1.amazonaws.com/checkmate-1511866_1280.jpg'
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
            'image' => 'https://fleamarket-bucket.s3.ap-northeast-1.amazonaws.com/shoes.jpg'
        ];
        DB::table('items')->insert($param);
    }
}
