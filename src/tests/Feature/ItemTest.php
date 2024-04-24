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
use App\Models\Purchase;
use App\Http\Requests\ItemRequest;
use Database\Seeders\CategoriesTableSeed;
use Database\Seeders\ContentsTableSeed;
use Database\Seeders\Category_contentsTableSeed;
use Database\Seeders\ConditionsTableSeed;
class ItemTest extends TestCase
{
    use DatabaseMigrations;

    private $userSell;
    private $userPurchase;
    private $firstItem;
    private $secondItem;

    public function setUp(): void
    {
        parent::setUp();
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
        $this->seed(CategoriesTableSeed::class);
        $this->seed(ContentsTableSeed::class);
        $this->seed(Category_contentsTableSeed::class);
        $this->seed(ConditionsTableSeed::class);
        $this->firstItem = Item::create([
            'user_id' => '1',
            'category_content_id' => '1',
            'condition_id' => '2',
            'name' => 'テスト商品登録',
            'brand_name' => 'テストブランド名',
            'explanation' => 'テスト商品の説明',
            'price' => '10000',
            'image' => '/storage/ai-generated-8674235_1280.png'
        ]);
        $this->secondItem = Item::create([
            'user_id' => '2',
            'category_content_id' => '2',
            'condition_id' => '2',
            'name' => 'TestItem',
            'brand_name' => '',
            'explanation' => 'TestItemの説明',
            'price' => '5000',
            'image' => '/storage/ai-generated-8674235_1280.png'
        ]);
        $this->purchase = Purchase::create([
            'user_id' => '1',
            'item_id' => '2'
        ]);
    }

    /** @test */
    public function getIndex()
    {
        $response = $this->get(route('index'));
        $response->assertOk()
        ->assertSee($this->firstItem->image, $this->secondItem->image)
        ->assertSee('SOLDOUT')
        ->assertSee(number_format($this->firstItem->price));
    }

    /** @test */
    public function getDetail()
    {
        $category_content_id = CategoryContent::find($this->firstItem->category_content_id);
        $this->category = Category::find($category_content_id->category_id);
        $this->content = Content::find($category_content_id->content_id);

        $response = $this->get("/item/{$this->firstItem->id}");
        $response->assertOk()
        ->assertViewIs('detail')
        ->assertSee($this->firstItem->name)
        ->assertSee($this->firstItem->brand_name)
        ->assertSee(number_format($this->firstItem->price))
        ->assertSee($this->firstItem->explanation)
        ->assertSee($this->firstItem->image)
        ->assertSee($this->category->name)
        ->assertSee($this->content->name)
        ->assertSee($this->firstItem->category_content_id)
        ->assertSee($this->firstItem->condition->name);
    }

    /** @test */
    public function getPurchaseDetail()
    {
        $category_content_id = CategoryContent::find($this->secondItem->category_content_id);
        $this->category = Category::find($category_content_id->category_id);
        $this->content = Content::find($category_content_id->content_id);

        $response = $this->get("/item/{$this->secondItem->id}");
        $response->assertOk()
        ->assertViewIs('detail')
        ->assertSee($this->secondItem->name)
        ->assertSee($this->secondItem->brand_name)
        ->assertSee('SOLDOUT')
        ->assertSee($this->secondItem->explanation)
        ->assertSee($this->secondItem->image)
        ->assertSee($this->category->name)
        ->assertSee($this->content->name)
        ->assertSee($this->secondItem->category_content_id)
        ->assertSee($this->secondItem->condition->name);
    }

    /** @test */
    public function getSellIndex()
    {
        $this->category = Category::all();
        $this->content = Content::all();

        $response = $this->get("/sell");
        $response->assertStatus(302);
    }

    /** @test */
    public function store()
    {
        Storage::fake('public');
        Storage::fake('s3');
        $file = UploadedFile::fake()->image('test-image.jpg');

        $response = $this->actingAs($this->userSell)->post('/sell',[
            'user_id' => $this->userSell->id,
            'category_content_id' => '3',
            'condition_id' => '3',
            'name' => 'UnitTestSell',
            'brand_name' => 'TestBrand',
            'explanation' => 'UnitTestSell',
            'price' => '8000',
            'image' => $file,
        ]);

        $response->assertStatus(302);

        $item = Item::where('name', 'UnitTestSell')->first();
        $this->assertNotNull($item);
        $this->assertDatabaseHas('items',[
            'id' => $item->id,
            'user_id' => $this->userSell->id,
            'category_content_id' => 3,
            'condition_id' => 3,
            'name' => 'UnitTestSell',
            'brand_name' => 'TestBrand',
            'explanation' => 'UnitTestSell',
            'price' => 8000,
            'image' => '/storage/test-image.jpg',
        ]);
    }

    /**
     *  @test
     *  @dataProvider dataItem
     */
    public function request(array $keys, array $values, bool $expect)
    {
        $dataList = array_combine($keys, $values);
        $request = new ItemRequest();
        $rules = $request->rules();
        $validator = Validator::make($dataList, $rules);
        $result = $validator->passes();
        $this->assertEquals($expect, $result);
    }

    public function dataItem()
    {
        $file = UploadedFile::fake()->image('test-image.jpg');
        $file_max = UploadedFile::fake()->image('test-image.jpg')->size(11000);
        $file_txt = UploadedFile::fake()->image('test-image.txt');
        return[
            'OK' => [
                ['category_content_id', 'condition_id', 'name', 'brand_name', 'explanation', 'price', 'image'],
                [1, 2, 'テスト商品登録', 'テストブランド名', 'テスト商品の説明', 10000, $file],
                true
            ],
            'カテゴリー選択必須' => [
                ['category_content_id', 'condition_id', 'name', 'brand_name', 'explanation', 'price', 'image'],
                [ null, 2, 'テスト商品登録', 'テストブランド名', 'テスト商品の説明', 10000, $file],
                false
            ],
            'コンディション選択必須' => [
                ['category_content_id', 'condition_id', 'name', 'brand_name', 'explanation', 'price', 'image'],
                [ 1, null, 'テスト商品登録', 'テストブランド名', 'テスト商品の説明', 10000, $file],
                false
            ],
            '商品名入力必須' => [
                ['category_content_id', 'condition_id', 'name', 'brand_name', 'explanation', 'price', 'image'],
                [1, 2, null, 'テストブランド名', 'テスト商品の説明', 10000, $file],
                false
            ],
            '商品名文字列' => [
                ['category_content_id', 'condition_id', 'name', 'brand_name', 'explanation', 'price', 'image'],
                [1, 2, 1, 'テストブランド名', 'テスト商品の説明', 10000, $file],
                false
            ],
            '商品名文字数' => [
                ['category_content_id', 'condition_id', 'name', 'brand_name', 'explanation', 'price', 'image'],
                [1, 2, str_repeat('a', 256), 'テストブランド名', 'テスト商品の説明', 10000, $file],
                false
            ],
            'ブランド名文字列' => [
                ['category_content_id', 'condition_id', 'name', 'brand_name', 'explanation', 'price', 'image'],
                [1, 2, 'テスト商品登録',1 , 'テスト商品の説明', 10000, $file],
                false
            ],
            'ブランド名文字列' => [
                ['category_content_id', 'condition_id', 'name', 'brand_name', 'explanation', 'price', 'image'],
                [1, 2, 'テスト商品登録',str_repeat('a', 256) , 'テスト商品の説明', 10000, $file],
                false
            ],
            '商品説明入力必須' => [
                ['category_content_id', 'condition_id', 'name', 'brand_name', 'explanation', 'price', 'image'],
                [1, 2, 'テスト商品登録', 'テストブランド名',null , 10000, $file],
                false
            ],
            '商品説明文字列' => [
                ['category_content_id', 'condition_id', 'name', 'brand_name', 'explanation', 'price', 'image'],
                [1, 2, 'テスト商品登録', 'テストブランド名',1 , 10000, $file],
                false
            ],
            '商品説明文字数' => [
                ['category_content_id', 'condition_id', 'name', 'brand_name', 'explanation', 'price', 'image'],
                [1, 2, 'テスト商品登録', 'テストブランド名',str_repeat('a', 256) , 10000, $file],
                false
            ],
            '金額入力必須' => [
                ['category_content_id', 'condition_id', 'name', 'brand_name', 'explanation', 'price', 'image'],
                [1, 2, 'テスト商品登録', 'テストブランド名', 'テスト商品の説明', null, $file],
                false
            ],
            '金額数値' => [
                ['category_content_id', 'condition_id', 'name', 'brand_name', 'explanation', 'price', 'image'],
                [1, 2, 'テスト商品登録', 'テストブランド名', 'テスト商品の説明', 'Test', $file],
                false
            ],
            '商品画像選択必須' => [
                ['category_content_id', 'condition_id', 'name', 'brand_name', 'explanation', 'price', 'image'],
                [1, 2, 'テスト商品登録', 'テストブランド名', 'テスト商品の説明', 10000, null],
                false
            ],
            '商品画像サイズ' => [
                ['category_content_id', 'condition_id', 'name', 'brand_name', 'explanation', 'price', 'image'],
                [1, 2, 'テスト商品登録', 'テストブランド名', 'テスト商品の説明', 10000, $file_max],
                false
            ],
            '商品画像種類' => [
                ['category_content_id', 'condition_id', 'name', 'brand_name', 'explanation', 'price', 'image'],
                [1, 2, 'テスト商品登録', 'テストブランド名', 'テスト商品の説明', 10000, $file_txt],
                false
            ],
        ];
    }
}
