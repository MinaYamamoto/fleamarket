<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilesTableSeedEc2 extends Seeder
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
            'post_code' => '1234567',
            'address' => '出品者テスト用住所登録',
            'building' => 'テスト用建物名登録',
            'profile_image' => 'https://fleamarket-bucket.s3.ap-northeast-1.amazonaws.com/clover-8108105_1280.jpg'
        ];
        DB::table('profiles')->insert($param);
        $param = [
            'user_id' => '3',
            'post_code' => '9876543',
            'address' => '購入者テスト用住所登録',
            'building' => '',
            'profile_image' => 'https://fleamarket-bucket.s3.ap-northeast-1.amazonaws.com/ai-generated-8674235_1280.png'
        ];
        DB::table('profiles')->insert($param);
    }
}
