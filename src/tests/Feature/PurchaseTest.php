<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Session;
use Mockery;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Content;
use App\Models\CategoryContent;
use App\Models\Condition;
use App\Models\Item;
use App\Models\Profile;
use App\Models\Purchase;
use App\Http\Controllers\PurchaseController;
use Database\Seeders\CategoriesTableSeed;
use Database\Seeders\ContentsTableSeed;
use Database\Seeders\Category_contentsTableSeed;
use Database\Seeders\ConditionsTableSeed;

class PurchaseTest extends TestCase
{
    use DatabaseMigrations;

    private $userPurchase;
    private $userNoProfile;
    private $item;

    public function setUp(): void
    {
        parent::setUp();
        $this->userPurchase = User::create([
            'name' => 'テスト　Unit1',
            'email' => 'unit1@email.com',
            'password' => \Hash::make('12345678'),
            'role' => 'user',
        ]);
        $this->userNoProfile = User::create([
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
    }

    /** @test */
    public function getIndex()
    {
        $post_code_3 = substr($this->profile->post_code, 0,3);
        $post_code_4 = substr($this->profile->post_code, 3);
        $post_code = $post_code_3. "-" . $post_code_4;

        $response = $this->actingAs($this->userPurchase)->get(route('purchase', ['item_id' => $this->item->id]));
        $response->assertOk()
        ->assertViewIs('purchase')
        ->assertSee($this->item->image)
        ->assertSee($this->item->name)
        ->assertSee(number_format($this->item->price))
        ->assertSee($post_code)
        ->assertSee($this->profile->address)
        ->assertSee($this->profile->building)
        ->assertSee('カード決済');
    }

    /** @test */
    public function indexNotLogin()
    {
        $response = $this->get(route('purchase', ['item_id' => $this->item->id]));
        $response->assertStatus(302)
        ->assertRedirect('/login');
    }

    /** @test */
    public function paymentCard()
    {
        Session::put('item_id', $this->item->id);
        Session::put('payment_method', 'card');
        $stripeMock = Mockery::mock('overload:\Stripe\Stripe');
        $stripeMock->shouldReceive('setApiKey')->once();
        $stripeProductMock = Mockery::mock('alias:\Stripe\Product');
        $stripeProductMock->shouldReceive('create')->once()->andReturn((object) ['id' => 'product_id']);
        $stripePriceMock = Mockery::mock('alias:\Stripe\Price');
        $stripePriceMock->shouldReceive('create')->once()->andReturn((object) ['id' => 'price_id']);
        $stripeCheckoutSessionMock = Mockery::mock('alias:\Stripe\Checkout\Session');
        $stripeCheckoutSessionMock->shouldReceive('create')->once()->andReturn((object) ['id' => 'session_id']);
        $response = $this->actingAs($this->userPurchase)->post("/checkout", ['payment_method' => 'card']);
        $response->assertOk()
        ->assertViewIs('checkout');
        $response->assertViewHasAll(['session', 'item_id']);
        $this->assertEquals('card', Session::get('payment_method'));
    }

    /** @test */
    public function paymentKonbini()
    {
        Session::put('item_id', $this->item->id);
        Session::put('payment_method', 'konbini');
        $stripeMock = Mockery::mock('overload:\Stripe\Stripe');
        $stripeMock->shouldReceive('setApiKey')->once();
        $stripeProductMock = Mockery::mock('alias:\Stripe\Product');
        $stripeProductMock->shouldReceive('create')->once()->andReturn((object) ['id' => 'product_id']);
        $stripePriceMock = Mockery::mock('alias:\Stripe\Price');
        $stripePriceMock->shouldReceive('create')->once()->andReturn((object) ['id' => 'price_id']);
        $stripeCheckoutSessionMock = Mockery::mock('alias:\Stripe\Checkout\Session');
        $stripeCheckoutSessionMock->shouldReceive('create')->once()->andReturn((object) ['id' => 'session_id']);
        $response = $this->actingAs($this->userPurchase)->post("/checkout", ['payment_method' => 'konbini']);
        $response->assertOk()
        ->assertViewIs('checkout');
        $response->assertViewHasAll(['session', 'item_id']);
        $this->assertEquals('konbini', Session::get('payment_method'));
    }
    /** @test */
    public function paymentBank()
    {
        Session::put('item_id', $this->item->id);
        Session::put('payment_method', 'bank');
        $stripeMock = Mockery::mock('overload:\Stripe\Stripe');
        $stripeMock->shouldReceive('setApiKey')->once();
        $stripeProductMock = Mockery::mock('alias:\Stripe\Product');
        $stripeProductMock->shouldReceive('create')->once()->andReturn((object) ['id' => 'product_id']);
        $stripePriceMock = Mockery::mock('alias:\Stripe\Price');
        $stripePriceMock->shouldReceive('create')->once()->andReturn((object) ['id' => 'price_id']);
        $customerMock = Mockery::mock('alias:\Stripe\Customer');
        $customerMock->shouldReceive('create')->once()->andReturn($customerMock);
        $stripeCheckoutSessionMock = Mockery::mock('alias:\Stripe\Checkout\Session');
        $stripeCheckoutSessionMock->shouldReceive('create')->once()->andReturn((object) ['id' => 'session_id']);
        $response = $this->actingAs($this->userPurchase)->post("/checkout", ['payment_method' => 'bank']);
        $response->assertOk()
        ->assertViewIs('checkout');
        $response->assertViewHasAll(['session', 'item_id']);
        $this->assertEquals('bank', Session::get('payment_method'));
    }

    /** @test */
    public function success()
    {
        Session::put('item_id', $this->item->id);
        $response = $this->actingAs($this->userPurchase)->get("/purchase/{$this->item->id}/payment/success");
        $response->assertOk()
        ->assertViewIs('success');
    }

    /** @test */
    public function store()
    {
        Session::put('item_id', $this->item->id);
        $response = $this->actingAs($this->userPurchase)->post("/purchase/{$this->item->id}/payment/success",[
            'user_id' => $this->userPurchase->id,
            'item_id' => $this->item->id,
        ]);
        $purchase = Purchase::where('user_id', $this->userPurchase->id)->first();
        $this->assertNotNull($purchase);
        $this->assertDatabaseHas('purchases',[
            'user_id' => $this->userPurchase->id,
            'item_id' => $this->item->id,
        ]);
        $response->assertRedirect(route('index'));
    }

    /** @test */
    public function storeNotLogin()
    {
        Session::put('item_id', $this->item->id);
        $response = $this->post("/purchase/{$this->item->id}/payment/success",[
            'user_id' => $this->userPurchase->id,
            'item_id' => $this->item->id,
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /** @test */
    public function paymentIndex()
    {
        $response = $this->actingAs($this->userPurchase)->get("/purchase/{{$this->item->id}}/payment");
        $response->assertOk()
        ->assertViewIs('payment')
        ->assertSee('カード決済')
        ->assertSee('コンビニ決済')
        ->assertSee('銀行決済');
    }

    /** @test */
    public function paymentChange()
    {
        Session::put('purchase_url', "/purchase/{{$this->item->id}}");
        $response = $this->actingAs($this->userPurchase)->post("/purchase/{{$this->item->id}}/payment", ['payment_method' => 'konbini']);
        $this->assertEquals('konbini', Session::get('payment_method'));
        $response->assertRedirect("/purchase/{{$this->item->id}}");
    }

    /** @test */
    public function addressIndex()
    {
        $response = $this->actingAs($this->userPurchase)->get("/purchase/address/{$this->userPurchase->id}");
        $response->assertOk()
        ->assertViewIs('address')
        ->assertSee($this->profile->post_code)
        ->assertSee($this->profile->address)
        ->assertSee($this->profile->building);
    }

    /** @test */
    public function changeAddress()
    {
        $response = $this->actingAs($this->userPurchase)->patch("/purchase/address/{$this->userPurchase->id}",[
            'profile_id' => $this->profile->id,
            'post_code' => 7890123,
            'address' => 'TestAddress',
            'building' => null
        ]);
        $response->assertStatus(302);
        $profile = Profile::where('user_id', $this->userPurchase->id)->first();
        $this->assertNotNull($profile);
        $this->assertDatabaseHas('profiles',[
            'post_code' => 7890123,
            'address' => 'TestAddress',
            'building' => null
        ]);
    }

    /** @test */
    public function noAddressForLocal()
    {
        Config::set('app.env', 'local');
        $response = $this->actingAs($this->userNoProfile)->post("/purchase/address/{$this->userNoProfile->id}",[
            'user_id' => $this->userNoProfile->id
        ]);
        $response->assertOk();
        $envValue = config('app.env');
        $this->assertEquals('local', $envValue);
        $profile = Profile::where('user_id', $this->userNoProfile->id)->first();
        $this->assertNotNull($profile);
        $this->assertDatabaseHas('profiles',[
            'post_code' => '',
            'address' => '住所未登録',
            'building' => null,
            'profile_image' => "/storage/profile.svg"
        ]);
    }

    /** @test */
    public function noAddressForS3()
    {
        Config::set('app.env', 'production');
        $response = $this->actingAs($this->userNoProfile)->post("/purchase/address/{$this->userNoProfile->id}",[
            'user_id' => $this->userNoProfile->id
        ]);
        $response->assertOk();
        $envValue = config('app.env');
        $this->assertEquals('production', $envValue);
        $profile = Profile::where('user_id', $this->userNoProfile->id)->first();
        $this->assertNotNull($profile);
        $this->assertDatabaseHas('profiles',[
            'post_code' => '',
            'address' => '住所未登録',
            'building' => null,
            'profile_image' => "https://fleamarket-bucket.s3.ap-northeast-1.amazonaws.com/profile.svg"
        ]);
    }
}
