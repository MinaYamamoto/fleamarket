<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Content;
use App\Models\CategoryContent;
use App\Models\Condition;
use App\Models\Item;
use App\Models\Mylist;
use Database\Seeders\CategoriesTableSeed;
use Database\Seeders\ContentsTableSeed;
use Database\Seeders\Category_contentsTableSeed;
use Database\Seeders\ConditionsTableSeed;
use Database\Seeders\MylistsTableSeed;
class ItemTest extends TestCase
{
    use DatabaseMigrations;

    private $users;
    private $firstItem;
    private $secondItem;

    public function setUp(): void
    {
        parent::setUp();
        $this->users = User::create([
            'name' => 'テスト　Unit1',
            'email' => 'unit1@email.com',
            'password' => \Hash::make('12345678'),
            'role' => 'user',
        ]);
        $this->users = User::create([
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
            'image' => '/storage/sak0109-003.jpg'
        ]);
        $this->secondItem = Item::create([
            'user_id' => '2',
            'category_content_id' => '2',
            'condition_id' => '2',
            'name' => 'TestItem',
            'brand_name' => '',
            'explanation' => 'TestItemの説明',
            'price' => '5000',
            'image' => '/storage/sak0109-003.jpg'
        ]);
        $this->seed(MylistsTableSeed::class);
    }

    /** @test */
    public function getIndex()
    {
        $response = $this->get(route('index'));
        $response->assertOk()
        ->assertSee($this->firstItem->image, $this->secondItem->image)
        ->assertSee(number_format($this->firstItem->price), number_format($this->secondItem->price));
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
    public function getSellIndex()
    {
        $response = $this->get("/sell");
        $response->assertOk()
        ->assertSee($this->category->name)
        ->assertSee($this->content->name)
        ->assertSee($this->condition->name);
    }
}
