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
            'user_id' => '3',
            'item_id' => '1',
            'comment' =>'購入者コメント登録'
        ];
        DB::table('comments')->insert($param);
        $param = [
            'user_id' => '2',
            'item_id' => '1',
            'comment' =>'出品者コメント登録'
        ];
        DB::table('comments')->insert($param);
        $param = [
            'user_id' => '2',
            'item_id' => '1',
            'comment' =>'出品者削除確認用コメント登録'
        ];
        DB::table('comments')->insert($param);
        $param = [
            'user_id' => '3',
            'item_id' => '1',
            'comment' =>'購入者削除確認用コメント登録'
        ];
        DB::table('comments')->insert($param);
        $param = [
            'user_id' => '4',
            'item_id' => '2',
            'comment' =>'TESTコメント登録1'
        ];
        DB::table('comments')->insert($param);
        $param = [
            'user_id' => '4',
            'item_id' => '2',
            'comment' =>'TESTコメント登録2'
        ];
        DB::table('comments')->insert($param);
        $param = [
            'user_id' => '5',
            'item_id' => '2',
            'comment' =>'TESTコメント登録3'
        ];
        DB::table('comments')->insert($param);
        $param = [
            'user_id' => '2',
            'item_id' => '2',
            'comment' =>'TESTコメント登録4'
        ];
        DB::table('comments')->insert($param);
    }
}
