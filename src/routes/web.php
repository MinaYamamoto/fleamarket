<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\MylistController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('redirects', [LoginController::class, 'index']);
Route::get('/', [ItemController::class, 'index'])->name('index');;
Route::get('/search', [ItemController::class, 'search']);
Route::get('/item/{item_id}', [ItemController::class, 'detail']);

Route::middleware('auth')->group(function() {
    Route::get('/sell',[ItemController::class, 'sellIndex']);
    Route::post('/sell',[ItemController::class, 'store']);
    Route::get('/mypage',[MypageController::class, 'index']);
    Route::get('/mypage/profile/{user_id}',[MypageController::class, 'profileIndex']);
    Route::post('/mypage/profile/{user_id}',[MypageController::class, 'profileStore']);
    Route::patch('/mypage/profile/{user_id}',[MypageController::class, 'profileUpdate']);
    Route::get('/purchase/{item_id}',[PurchaseController::class, 'index'])->name('purchase');
    Route::get('/purchase/{item_id}/payment',[PurchaseController::class, 'paymentIndex']);
    Route::post('/purchase/{item_id}/payment',[PurchaseController::class, 'paymentChange']);
    Route::get('/purchase/{item_id}/payment/success',[PurchaseController::class, 'success'])->name('success');
    Route::post('/purchase/{item_id}/payment/success',[PurchaseController::class, 'store']);
    Route::get('/purchase/address/{user_id}',[PurchaseController::class, 'addressIndex']);
    Route::post('/purchase/address/{user_id}',[PurchaseController::class, 'addressStore']);
    Route::patch('/purchase/address/{user_id}',[PurchaseController::class, 'addressUpdate']);
    Route::post('/checkout', [PurchaseController::class, 'checkout'])->name('checkout');
    Route::post('/mylist/{item_id}', [MylistController::class, 'store']);
    Route::delete('/mylist/{item_id}', [MylistController::class, 'destroy']);
    Route::get('/comment/{item_id}', [CommentController::class, 'index']);
    Route::post('/comment/{item_id}', [CommentController::class, 'store']);
});

Route::group(['middleware' => ['auth', 'can:admin-authority']], function() {
    Route::get('/admin', [AdminController::class,'index']);
    Route::get('/admin/comment', [AdminController::class,'commentIndex']);
    Route::delete('/admin/comment/{comment_id}', [AdminController::class,'commentDestroy']);
    Route::get('/admin/user', [AdminController::class,'userIndex']);
    Route::delete('/admin/user/{user_id}', [AdminController::class,'userDestroy']);
    Route::get('/admin/maillist', [AdminController::class, 'mailListIndex']);
    Route::get('/admin/mail', [MailController::class, 'index']);
    Route::post('/admin/mail/execute', [MailController::class, 'execute']);
});