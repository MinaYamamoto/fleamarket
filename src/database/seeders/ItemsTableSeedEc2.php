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
    }
}
