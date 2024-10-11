<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ItemDetailController;
use App\Http\Controllers\MyListController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\PaymentMethodController;
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

Route::get('/guest', [GuestController::class, 'guestIndex']);
Route::get('/guest/item/{item_id}', [GuestController::class, 'guestItemDetail'])->name('items.guest_detail');
Route::get('/guest/unauthorized_access', [GuestController::class, 'unauthorizedAccess'])->name('guest.unauthorized_access');
Route::get('/search', [SearchController::class, 'resultSearch']);


Route::middleware('auth')->group(function () {
    Route::get('/', [TopPageController::class, 'userIndex']);
    Route::get('/my-list', [MyListController::class, 'index']);
    Route::get('/item/{item_id}', [ItemDetailController::class, 'userItemDetail'])->name('items.user_detail');
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'showPurchase'])->name('purchase.show');
    Route::post('/purchase/{item_id}', [PurchaseController::class, 'purchase'])->name('items.purchase');
    Route::get('/purchase/address/{item_id}', [AddressController::class, 'editAddress'])->name('purchase.edit.address');
    Route::put('/purchase/address/{item_id}', [AddressController::class, 'updateAddress'])->name('purchase.update.address');
    Route::get('/payment-method/{item_id}', [PaymentMethodController::class, 'showPaymentMethod'])->name('payment_method.show');
    Route::post('/payment-method/{item_id}', [PaymentMethodController::class, 'updatePaymentMethod'])->name('payment_method.update');
    Route::get('/payment-method/add/{item_id}', [PaymentMethodController::class, 'showAddPaymentMethod'])->name('payment_method.add.show');
    Route::post('/payment-method/add/{item_id}', [PaymentMethodController::class, 'addPaymentMethod'])->name('payment_method.add.submit');
    Route::delete('/payment-method/delete/{item_id}', [PaymentMethodController::class, 'deletePaymentMethod'])->name('payment_method.delete');
    Route::get('/comment/{item_id}', [CommentController::class, 'show'])->name('comment.show');
    Route::post('/comment/{item_id}', [CommentController::class, 'store'])->name('comment.store');
    Route::get('/my-page', [MyPageController::class, 'index']);
    Route::get('/my-page/profile', [ProfileController::class, 'edit']);
    Route::put('/my-page/profile', [ProfileController::class, 'update']);
    Route::get('/sell', [SellController::class, 'index'])->name('sell.index');
    Route::post('/sell', [SellController::class, 'store']);
    Route::post('/like/{item_id}', [FavoriteController::class, 'store'])->name('like');
    Route::post('/unlike/{item_id}', [FavoriteController::class, 'delete'])->name('unlike');
});
