<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'テスト　admin',
            'email' => 'admin@email.com',
            'password' => \Hash::make('12345678'),
            'role' => 'admin',
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => 'テスト　ItemUser',
            'email' => 'user1@email.com',
            'password' => \Hash::make('12345678'),
            'role' => 'user',
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => 'テスト　PurchaseUser',
            'email' => 'user2@email.com',
            'password' => \Hash::make('12345678'),
            'role' => 'user',
        ];
        DB::table('users')->insert($param);
    }
}
