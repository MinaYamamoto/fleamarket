<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
