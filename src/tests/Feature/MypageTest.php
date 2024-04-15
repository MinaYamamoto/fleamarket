<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Content;
use App\Models\CategoryContent;
use App\Models\Condition;
use App\Models\Item;
use App\Models\Profile;
use App\Http\Requests\MypageRequest;
use Database\Seeders\CategoriesTableSeed;
use Database\Seeders\ContentsTableSeed;
use Database\Seeders\Category_contentsTableSeed;
use Database\Seeders\ConditionsTableSeed;

class MypageTest extends TestCase
{
    use DatabaseMigrations;

    private $myPageUser;
    private $user;
    private $sellItem;
    private $purchaseItem;

        public function setUp(): void
    {
        parent::setUp();
        $this->myPageUser = User::create([
            'name' => 'テスト　Unit1',
            'email' => 'unit1@email.com',
            'password' => \Hash::make('12345678'),
            'role' => 'user',
        ]);
        $this->user = User::create([
            'name' => 'テスト　Unit2',
            'email' => 'unit2@email.com',
            'password' => \Hash::make('12345678'),
            'role' => 'user',
        ]);
        $this->profile = Profile::create([
            'user_id' => '1',
            'post_code' => '1234567',
            'address' => 'テスト用住所登録',
            'building' => 'テスト用建物名登録',
            'profile_image' => '/storage/sak0109-003.jpg'
        ]);
        $this->seed(CategoriesTableSeed::class);
        $this->seed(ContentsTableSeed::class);
        $this->seed(Category_contentsTableSeed::class);
        $this->seed(ConditionsTableSeed::class);
        $this->sellItem = Item::create([
            'user_id' => '1',
            'category_content_id' => '1',
            'condition_id' => '2',
            'name' => 'テスト商品登録',
            'brand_name' => 'テストブランド名',
            'explanation' => 'テスト商品の説明',
            'price' => '10000',
            'image' => '/storage/sak0109-003.jpg'
        ]);
        $this->purchaseItem = Item::create([
            'user_id' => '2',
            'category_content_id' => '2',
            'condition_id' => '2',
            'name' => 'TestItem',
            'brand_name' => '',
            'explanation' => 'TestItemの説明',
            'price' => '5000',
            'image' => '/storage/sak0109-003.jpg'
        ]);
    }
    /** @test */
    public function getIndex()
    {
        $response = $this->actingAs($this->myPageUser)->get('mypage');
        $response->assertOk()
        ->assertViewIs('mypage')
        ->assertSee($this->myPageUser->name)
        ->assertSee($this->profile->profile_image)
        ->assertSee($this->sellItem->image, $this->purchaseItem->image)
        ->assertSee(number_format($this->sellItem->price), number_format($this->purchaseItem->price));
    }

        /** @test */
    public function getProfileIndex()
    {
        $response = $this->actingAs($this->myPageUser)->get("/mypage/profile/{$this->myPageUser}");
        $response->assertOk()
        ->assertViewIs('profile')
        ->assertSee($this->myPageUser->name)
        ->assertSee($this->profile->profile_image)
        ->assertSee($this->profile->post_code)
        ->assertSee($this->profile->address)
        ->assertSee($this->profile->building);
    }

    /** @test */
    public function profileUpdate()
    {
        Storage::fake('public');
        Storage::fake('s3');
        $file = UploadedFile::fake()->image('test-image.jpg');
        $response = $this->actingAs($this->myPageUser)->patch("/mypage/profile/{$this->myPageUser}",[
            'user_id' => $this->myPageUser->id,
            'profile_id' => $this->profile->id,
            'name' => 'Change Name',
            'profile_image' => $file,
            'post_code' => 1234567,
            'address' => 'TestAddress',
            'building' => null
        ]);
        $response->assertStatus(302);

        $profile = Profile::where('user_id', $this->myPageUser->id)->first();
        $this->assertNotNull($profile);
        $this->assertDatabaseHas('profiles',[
            'profile_image' => '/storage/test-image.jpg',
            'post_code' => 1234567,
            'address' => 'TestAddress',
            'building' => null
        ]);
        $user = profile::find($this->myPageUser->id);
        $this->assertNotNull($user);
        $this->assertDatabaseHas('users',[
            'name' => 'Change Name',
        ]);
    }

    /**
     *  @test
     *  @dataProvider dataMyPage
     */
    public function request(array $keys, array $values, bool $expect)
    {
        $dataList = array_combine($keys, $values);
        $request = new MypageRequest();
        $rules = $request->rules();
        $validator = Validator::make($dataList, $rules);
        $result = $validator->passes();
        $this->assertEquals($expect, $result);
    }

    public function dataMyPage()
    {
        $file = UploadedFile::fake()->image('test-image.jpg');
        $file_max = UploadedFile::fake()->image('test-image.jpg')->size(11000);
        $file_txt = UploadedFile::fake()->image('test-image.txt');
        return[
            'OK' => [
                ['name', 'post_code', 'address', 'building', 'profile_image'],
                ['Test Name', '1234567', 'TestAddress', 'TestBuilding', $file],
                true
            ],
            '名前入力必須' => [
                ['name', 'post_code', 'address', 'building', 'profile_image'],
                [null, '1234567', 'TestAddress', 'TestBuilding', $file],
                false
            ],
            '名前文字列' => [
                ['name', 'post_code', 'address', 'building', 'profile_image'],
                [1, '1234567', 'TestAddress', 'TestBuilding', $file],
                false
            ],
            '名前文字数' => [
                ['name', 'post_code', 'address', 'building', 'profile_image'],
                [str_repeat('a', 61), '1234567', 'TestAddress', 'TestBuilding', $file],
                false
            ],
            '郵便番号入力必須' => [
                ['name', 'post_code', 'address', 'building', 'profile_image'],
                ['Test Name', null, 'TestAddress', 'TestBuilding', $file],
                false
            ],
            '郵便番号数字' => [
                ['name', 'post_code', 'address', 'building', 'profile_image'],
                ['Test Name', 'Test', 'TestAddress', 'TestBuilding', $file],
                false
            ],
            '郵便番号文字数' => [
                ['name', 'post_code', 'address', 'building', 'profile_image'],
                ['Test Name', 12345678, 'TestAddress', 'TestBuilding', $file],
                false
            ],
            '住所入力必須' => [
                ['name', 'post_code', 'address', 'building', 'profile_image'],
                ['Test Name', '1234567', null, 'TestBuilding', $file],
                false
            ],
            '住所文字列' => [
                ['name', 'post_code', 'address', 'building', 'profile_image'],
                ['Test Name', '1234567', 1, 'TestBuilding', $file],
                false
            ],
            '住所文字数' => [
                ['name', 'post_code', 'address', 'building', 'profile_image'],
                ['Test Name', '1234567', str_repeat('a', 256), 'TestBuilding', $file],
                false
            ],
            'プロフィール画像サイズ' => [
                ['name', 'post_code', 'address', 'building', 'profile_image'],
                ['Test Name', '1234567', 'TestAddress', 'TestBuilding', $file_max],
                false
            ],
            'プロフィール画像種類' => [
                ['name', 'post_code', 'address', 'building', 'profile_image'],
                ['Test Name', '1234567', 'TestAddress', 'TestBuilding', $file_txt],
                false
            ],
        ];
    }

}
