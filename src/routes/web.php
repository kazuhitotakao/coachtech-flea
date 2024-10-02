<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\DeliveryAddressController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ItemDetailController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\TopPageController;
use Illuminate\Support\Facades\Route;

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
Route::get('/guest', [TopPageController::class, 'guestIndex']);
Route::get('/guest/item/{item_id}', [ItemDetailController::class, 'guestItemDetail'])->name('items.guest_detail');
Route::get('/search', [SearchController::class, 'resultSearch']);


Route::middleware('auth')->group(function () {
    Route::get('/', [TopPageController::class, 'userIndex']);
    Route::get('/item/{item_id}', [ItemDetailController::class, 'userItemDetail'])->name('items.user_detail');
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'showPurchase'])->name('purchase.show');
    Route::post('/purchase/{item_id}', [PurchaseController::class, 'purchase'])->name('items.purchase');
    Route::get('/purchase/address/{item_id}', [DeliveryAddressController::class, 'editDeliveryAddress'])->name('purchase.edit.address');
    Route::post('/purchase/address/{item_id}', [DeliveryAddressController::class, 'updateDeliveryAddress'])->name('purchase.update.address');
    Route::get('/comment/{item_id}', [CommentController::class, 'show'])->name('comment.show');
    Route::post('/comment/{item_id}', [CommentController::class, 'store'])->name('comment.store');
    Route::get('/my-page', [MyPageController::class, 'index']);
    Route::get('/my-page/profile', [ProfileController::class, 'edit']);
    Route::post('/my-page/profile', [ProfileController::class, 'update']);
    Route::get('/sell', [SellController::class, 'index'])->name('sell.index');
    Route::post('/sell', [SellController::class, 'store']);
    Route::post('/like/{item_id}', [FavoriteController::class, 'store'])->name('like');
    Route::post('/unlike/{item_id}', [FavoriteController::class, 'delete'])->name('unlike');
});
