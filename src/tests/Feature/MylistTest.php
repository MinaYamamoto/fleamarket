<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
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

class MylistTest extends TestCase
{

    use DatabaseMigrations;

    private $user;
    private $item;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::create([
            'name' => 'テスト　Unit1',
            'email' => 'unit1@email.com',
            'password' => \Hash::make('12345678'),
            'role' => 'user',
        ]);
        $this->seed(CategoriesTableSeed::class);
        $this->seed(ContentsTableSeed::class);
        $this->seed(Category_contentsTableSeed::class);
        $this->seed(ConditionsTableSeed::class);
        $this->item = Item::create([
            'user_id' => '1',
            'category_content_id' => '1',
            'condition_id' => '2',
            'name' => 'テスト商品登録',
            'brand_name' => 'テストブランド名',
            'explanation' => 'テスト商品の説明',
            'price' => '10000',
            'image' => '/storage/ai-generated-8674235_1280.png'
        ]);
    }

    /** @test */
    public function store()
    {
        $response = $this->actingAs($this->user)->post("/mylist/{$this->item->id}",[
            'user_id' => $this->user->id,
            'item_id' => $this->item->id,
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('mylists',[
            'user_id' => $this->user->id,
            'item_id' => $this->item->id,
        ]);
    }

    /** @test */
    public function deleteCheck()
    {
        $mylist = Mylist::create([
            'user_id' => $this->user->id,
            'item_id' => $this->item->id]);
        $response = $this->actingAs($this->user)->delete("/mylist/{$this->item->id}");
        $response->assertStatus(302);
        $this->assertDeleted('mylists', [
            'user_id' => $this->user->id,
            'item_id' => $this->item->id
        ]);
    }

    /** @test */
    public function nonLoginUserStore()
    {
        $response = $this->post("/mylist/{$this->item->id}");
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /** @test */
    public function nonLoginUserDelete()
    {
        $response = $this->delete("/mylist/{$this->item->id}");
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }
}
