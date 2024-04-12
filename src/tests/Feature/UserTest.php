<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;
    private $admin;
    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->admin = User::create([
            'name' => 'テスト　admin1',
            'email' => 'admin1@email.com',
            'password' => \Hash::make('12345678'),
            'role' => 'admin',
        ]);
        $this->user = User::create([
            'name' => 'テスト　Unit1',
            'email' => 'unit1@email.com',
            'password' => \Hash::make('12345678'),
            'role' => 'user',
        ]);

    }

    /** @test */
    public function userLogin()
    {
        $this->post('/login',[
            'email' => 'unit1@email.com',
            'password' => '12345678',
        ])->assertRedirect('/redirects');

        $this->get('/redirects',[
            'role' => 'user'
        ])->assertRedirect('/mypage');
    }

    /** @test */
    public function adminLogin()
    {
        $this->post('login',[
            'email' => 'admin1@email.com',
            'password' => '12345678',
        ])->assertRedirect('/redirects');

        $this->get('redirects',[
            'role' => 'admin'
        ])->assertRedirect('/admin');

    }

    /** @test */
    public function failureUserLogin()
    {
        $this->post('login',[
            'email' => 'test@email.com',
            'password' => '12345678',
        ])->assertInvalid(['email' => '認証情報と一致するレコードがありません']);
        $this->post('login',[
            'email' => 'unit1@email.com',
            'password' => 'hogehoge',
        ])->assertInvalid(['email' => '認証情報と一致するレコードがありません']);
    }

    /** @test */
    public function request()
    {
        $this->post('login',[
            'email' => 'admin1@email.com',
            'password' => '',
        ])->assertInvalid(['password' => 'パスワードを入力してください']);

        $this->post('login',[
            'email' => '',
            'password' => '12345678',
        ])->assertInvalid(['email' => 'メールアドレスを入力してください']);

        $this->post('login',[
            'email' => 'test',
            'password' => '12345678',
        ])->assertInvalid(['email' => 'メールアドレスは「ユーザ名@ドメイン」形式で入力してください']);
    }
}
