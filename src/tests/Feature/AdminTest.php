<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Comment;
use Database\Seeders\CategoriesTableSeed;
use Database\Seeders\ContentsTableSeed;
use Database\Seeders\Category_contentsTableSeed;
use Database\Seeders\ConditionsTableSeed;

class AdminTest extends TestCase
{
    use DatabaseMigrations;

    private $admin;
    private $userPurchase;
    private $userSeller;
    private $item;
    private $comment;
    private $delete_comment;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(CategoriesTableSeed::class);
        $this->seed(ContentsTableSeed::class);
        $this->seed(Category_contentsTableSeed::class);
        $this->seed(ConditionsTableSeed::class);
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
        $this->userSeller = User::create([
            'name' => 'テスト　Unit2',
            'email' => 'unit2@email.com',
            'password' => \Hash::make('12345678'),
            'role' => 'user',
        ]);
        $this->item = Item::create([
            'user_id' => '3',
            'category_content_id' => '1',
            'condition_id' => '2',
            'name' => 'テスト商品登録',
            'brand_name' => 'テストブランド名',
            'explanation' => 'テスト商品の説明',
            'price' => '10000',
            'image' => '/storage/sak0109-003.jpg'
        ]);
        $this->comment = Comment::create([
            'user_id' => '2',
            'item_id' => '1',
            'comment' => 'テストコメント'
        ]);
    }

    /** @test */
    public function index()
    {
        $response = $this->actingAs($this->admin)->get('/admin');
        $response->assertOk()
        ->assertViewIs('admin.admin');
    }

    /** @test */
    public function nonAdmin()
    {
        $response = $this->actingAs($this->userSeller)->get('/admin');
        $response->assertStatus(403);
    }

    /** @test */
    public function commentIndex()
    {
        $response = $this->actingAs($this->admin)->get('/admin/comment');
        $response->assertOk()
        ->assertViewIs('admin.delete_comment')
        ->assertSee($this->userPurchase->name)
        ->assertSee($this->comment->comment);
    }

    /** @test */
    public function commentDelete()
    {
        $this->delete_comment = Comment::create([
            'user_id' => '3',
            'item_id' => '1',
            'comment' => 'Delete'
        ]);
        $response = $this->actingAs($this->admin)->delete("/admin/comment/{$this->delete_comment->id}");
        $response->assertStatus(302);
        $this->assertDeleted('comments', [
            'user_id' => $this->userSeller->id,
            'item_id' => $this->item->id,
            'comment' => 'Delete'
        ]);
    }

    /** @test */
    public function mailIndex()
    {
        $response = $this->actingAs($this->admin)->get('/admin/maillist');
        $response->assertOk()
        ->assertViewIs('admin.mail_list')
        ->assertSee($this->userPurchase->name)
        ->assertSee($this->userPurchase->email)
        ->assertSee($this->userSeller->name)
        ->assertSee($this->userSeller->email);
    }

    /** @test */
    public function userIndex()
    {
        $response = $this->actingAs($this->admin)->get('/admin/user');
        $response->assertOk()
        ->assertViewIs('admin.delete_user')
        ->assertSee($this->userPurchase->name)
        ->assertSee($this->userPurchase->email)
        ->assertSee($this->userSeller->name)
        ->assertSee($this->userSeller->email);
    }

    /** @test */
    public function userDelete()
    {
        $response = $this->actingAs($this->admin)->delete("/admin/user/{$this->userSeller->id}");
        $response->assertStatus(302);
        $this->assertDeleted('users', [
            'name' => 'テスト　Unit2',
            'email' => 'unit2@email.com',
            'password' => \Hash::make('12345678'),
            'role' => 'user',
        ]);
    }
}
