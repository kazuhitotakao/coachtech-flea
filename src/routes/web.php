<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemDetailController;
use App\Http\Controllers\MailSendController;
use App\Http\Controllers\MyListController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TopPageController;
use App\Http\Controllers\UserImageController;
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
    Route::get('/', [TopPageController::class, 'userIndex'])->name('top.page');
    Route::get('/my-list', [MyListController::class, 'index'])->name('my.list');
    Route::get('/item/create', [ItemController::class, 'create'])->name('item.create');
    Route::post('/item/store', [ItemController::class, 'store'])->name('item.store');
    Route::post('/item/images', [ItemController::class, 'upload'])->name('item.images.upload');
    Route::get('/item/{item_id}', [ItemDetailController::class, 'userItemDetail'])->name('item.user_detail');
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'showPurchase'])->name('purchase.show');
    Route::post('/purchase/{item_id}', [PurchaseController::class, 'purchase'])->name('items.purchase');
    Route::get('/purchase/address/{item_id}', [AddressController::class, 'editAddress'])->name('purchase.edit.address');
    Route::put('/purchase/address/{item_id}', [AddressController::class, 'updateAddress'])->name('purchase.update.address');
    Route::get('/comment/{item_id}', [CommentController::class, 'show'])->name('comment.show');
    Route::post('/comment/{item_id}', [CommentController::class, 'store'])->name('comment.store');
    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/admin-page/users', [AdminController::class, 'indexUsers'])->name('admin.users.index');
        Route::get('/admin-page/users/search', [AdminController::class, 'searchUser'])->name('admin.users.search');
        Route::delete('/admin-page/users/{user_id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
        Route::get('/admin-page/comments', [AdminController::class, 'indexComments'])->name('admin.comments.index');
        Route::get('/admin-page/comments/search', [AdminController::class, 'searchComment'])->name('admin.comments.search');
        Route::delete('/admin-page/comments/bulk-delete', [AdminController::class, 'destroyComments'])->name('admin.comments.bulk_destroy');
        Route::delete('/admin-page/comments/{comment_id}', [AdminController::class, 'destroyComment'])->name('admin.comments.destroy');
    });
    Route::get('/payment-method/{item_id}', [PaymentMethodController::class, 'showPaymentMethod'])->name('payment_method.show');
    Route::post('/payment-method/{item_id}', [PaymentMethodController::class, 'updatePaymentMethod'])->name('payment_method.update');
    Route::get('/payment/create/{item_id}', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('/payment/store/{item_id}', [PaymentController::class, 'store'])->name('payment.store');
    Route::get('/my-page/listed', [MyPageController::class, 'indexListed'])->name('my_page.listed');
    Route::get('/my-page/purchased', [MyPageController::class, 'indexPurchased'])->name('my_page.purchased');
    Route::get('/my-page/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/my-page/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/user/images', [UserImageController::class, 'upload'])->name('user.images.upload');
    Route::post('/like/{item_id}', [FavoriteController::class, 'store'])->name('like');
    Route::post('/unlike/{item_id}', [FavoriteController::class, 'delete'])->name('unlike');
    Route::get('/mail/admin-to-user', [MailSendController::class, 'adminToUser'])->name('mail.send.admin_to_user');
    Route::get('/mail/admin-to-users', [MailSendController::class, 'adminToUsers'])->name('mail.send.admin_to_users');
});
