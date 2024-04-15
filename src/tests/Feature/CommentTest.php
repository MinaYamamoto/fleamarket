<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Content;
use App\Models\CategoryContent;
use App\Models\Condition;
use App\Models\Item;
use App\Models\Comment;
use App\Http\Requests\CommentRequest;
use Database\Seeders\CategoriesTableSeed;
use Database\Seeders\ContentsTableSeed;
use Database\Seeders\Category_contentsTableSeed;
use Database\Seeders\ConditionsTableSeed;

class CommentTest extends TestCase
{

    use DatabaseMigrations;

    private $userSell;
    private $userPurchase;
    private $item;
    private $comment;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(CategoriesTableSeed::class);
        $this->seed(ContentsTableSeed::class);
        $this->seed(Category_contentsTableSeed::class);
        $this->seed(ConditionsTableSeed::class);
        $this->userSell = User::create([
            'name' => 'テスト　Unit1',
            'email' => 'unit1@email.com',
            'password' => \Hash::make('12345678'),
            'role' => 'user',
        ]);
        $this->userPurchase = User::create([
            'name' => 'テスト　Unit2',
            'email' => 'unit2@email.com',
            'password' => \Hash::make('12345678'),
            'role' => 'user',
        ]);
        $this->item = Item::create([
            'user_id' => '1',
            'category_content_id' => '1',
            'condition_id' => '2',
            'name' => 'テスト商品登録',
            'brand_name' => 'テストブランド名',
            'explanation' => 'テスト商品の説明',
            'price' => '10000',
            'image' => '/storage/sak0109-003.jpg'
        ]);
        $this->comment = Comment::create([
            'user_id' => '1',
            'item_id' => '1',
            'comment' => 'テストコメント'
        ]);
    }

    /** @test */
    public function route()
    {
        $response = $this->actingAs($this->userPurchase)->get("/comment/{$this->item->id}");
        $response->assertStatus(200)
        ->assertViewIs('comment')
        ->assertSee($this->item->name)
        ->assertSee($this->item->brand_name)
        ->assertSee(number_format($this->item->price))
        ->assertSee($this->item->image)
        ->assertSee($this->comment->comment);

    }

    /** @test */
    public function Store()
    {
        $response = $this->actingAs($this->userPurchase)->post("/comment/{$this->item->id}",[
            'user_id' => $this->userPurchase->id,
            'item_id' => $this->item->id,
            'comment' => 'TEST'
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('comments',[
            'user_id' => $this->userPurchase->id,
            'item_id' => $this->item->id,
            'comment' => 'TEST'
        ]);
    }

    /**
     *  @test
     *  @dataProvider dataComment
     */
    public function request(array $keys, array $values, bool $expect)
    {
        $dataList = array_combine($keys, $values);
        $request = new CommentRequest();
        $rules = $request->rules();
        $validator = Validator::make($dataList, $rules);
        $result = $validator->passes();
        $this->assertEquals($expect, $result);
    }

    public function dataComment()
    {
        return[
            'OK' => [
                ['comment'],
                ['テストコメント登録'],
                true
            ],
            '入力必須' => [
                ['comment'],
                [null],
                false
            ],
            '最大文字数' => [
                ['comment'],
                [str_repeat('a', 256)],
                false
            ],
            '文字列型' => [
                ['comment'],
                [1],
                false
            ],
        ];
    }
}
