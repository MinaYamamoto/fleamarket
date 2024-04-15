<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\Models\User;
use App\Http\Requests\MailRequest;


class MailTest extends TestCase
{
    use DatabaseMigrations;

    private $admin;
    private $userPurchase;
    public function setUp(): void
    {
        parent::setUp();
        $this->admin = User::create([
            'name' => 'テスト　admin',
            'email' => 'admin1@email.com',
            'password' => \Hash::make('12345678'),
            'role' => 'admin',
        ]);
        $this->userPurchase = User::create([
            'name' => 'テスト　Unit1',
            'email' => 'unit1@email.com',
            'password' => \Hash::make('12345678'),
            'role' => 'user',
        ]);
    }

    /** @test */
    public function mail()
    {
        $response = $this->actingAs($this->admin)->post('/admin/mail',[
            'user_name' => $this->userPurchase->name,
            'user_email' => $this->userPurchase->email
        ]);
        $response->assertOk()
        ->assertViewIs('admin.mail')
        ->assertSee($this->userPurchase->name)
        ->assertSee($this->userPurchase->email);
    }

    /** @test */
    public function sendMail()
    {
        Mail::fake();
        $response = $this->actingAs($this->admin)->post('/admin/mail/execute',[
            'name' => $this->userPurchase->name,
            'email' => $this->userPurchase->email,
            'subject' => 'TestSubject',
            'txt' => 'TestText'
        ]);
        $response->assertOk();
    }

    /**
     *  @test
     *  @dataProvider dataMail
     */
    public function request(array $keys, array $values, bool $expect)
    {
        $dataList = array_combine($keys, $values);
        $request = new MailRequest();
        $rules = $request->rules();
        $validator = Validator::make($dataList, $rules);
        $result = $validator->passes();
        $this->assertEquals($expect, $result);
    }

    public function dataMail()
    {
        return[
            'OK' => [
                ['name', 'email', 'subject'],
                ['Test Name', 'testmail@email.com', 'TestSubject'],
                true
            ],
            '名前必須' => [
                ['name', 'email', 'subject'],
                [null, 'testmail@email.com', 'TestSubject'],
                false
            ],
            '名前文字列' => [
                ['name', 'email', 'subject'],
                [1, 'testmail@email.com', 'TestSubject'],
                false
            ],
            'メール必須' => [
                ['name', 'email', 'subject'],
                ['Test Name', null, 'TestSubject'],
                false
            ],
            'メール形式' => [
                ['name', 'email', 'subject'],
                ['Test Name', 'test', 'TestSubject'],
                false
            ],
            '件名必須' => [
                ['name', 'email', 'subject'],
                ['Test Name', 'testmail@email.com', null],
                false
            ],
        ];
    }
}
