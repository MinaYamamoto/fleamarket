<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\MylistController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;

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
Route::get('/', [ItemController::class, 'index']);
Route::get('/search', [ItemController::class, 'search']);
Route::get('/item/{item_id}', [ItemController::class, 'detail']);

Route::middleware('auth')->group(function() {
    Route::get('/sell',[ItemController::class, 'sellindex']);
    Route::post('/sell',[ItemController::class, 'store']);
    Route::get('/mypage',[MypageController::class, 'index']);
    Route::get('/mypage/profile/{user_id}',[MypageController::class, 'profileindex']);
    Route::post('/mypage/profile/{user_id}',[MypageController::class, 'profilestore']);
    Route::patch('/mypage/profile/{user_id}',[MypageController::class, 'profileupdate']);
    Route::get('purchase/{item_id}',[PurchaseController::class, 'index'])->name('purchase');
    Route::post('purchase/{item_id}',[PurchaseController::class, 'store']);
    Route::post('purchase/address/{user_id}',[PurchaseController::class, 'addressstore']);
    Route::get('purchase/address/{user_id}',[PurchaseController::class, 'addressindex']);
    Route::patch('purchase/address/{user_id}',[PurchaseController::class, 'addressupdate']);
    Route::post('/mylist/{item_id}', [MylistController::class, 'store']);
    Route::delete('/mylist/{item_id}', [MylistController::class, 'destroy']);
    Route::get('/comment/{item_id}', [CommentController::class, 'index']);
    Route::post('/comment/{item_id}', [CommentController::class, 'store']);
});

Route::group(['middleware' => ['auth', 'can:admin-authority']], function() {
    Route::get('/admin/comment', [CommentController::class,'adminindex']);
    Route::delete('/admin/comment/{comment_id}', [CommentController::class,'admindestroy']);
    Route::get('/admin/user', [UserController::class,'adminindex']);
    Route::delete('/admin/user/{user_id}', [UserController::class,'admindestroy']);
    Route::get('/admin/mail', [MailController::class, 'index']);
    Route::post('/admin/mail/execute', [MailController::class, 'execute']);
});