<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsTableSeed extends Seeder
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
            'item_id' => '1',
            'comment' =>'購入者コメント登録'
        ];
        DB::table('comments')->insert($param);
        $param = [
            'user_id' => '1',
            'item_id' => '1',
            'comment' =>'出品者コメント登録'
        ];
        DB::table('comments')->insert($param);
        $param = [
            'user_id' => '2',
            'item_id' => '1',
            'comment' =>'削除確認用コメント登録'
        ];
        DB::table('comments')->insert($param);
    }
}
