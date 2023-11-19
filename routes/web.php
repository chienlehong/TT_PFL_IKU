<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SaveController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Psy\Readline\HoaConsole;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/',[HomeController::class,'index'])->name('homepage');

Route::get('/sach/{id}',[HomeController::class,'viewBook'])->name('viewBook');
Route::get('/danh-muc/{id}',[HomeController::class,'viewCategory'])->name('viewCategory');
Route::get('/sach-ban-chay-trong-tuan',[HomeController::class,'viewHotBookWeek'])->name('viewHotBookWeek');
Route::get('/sach-ban-chay-trong-thang',[HomeController::class,'viewHotBookMonth'])->name('viewHotBookMonth');
Route::get('/sach-ban-moi-xuat-ban',[HomeController::class,'viewBookNewPublish'])->name('viewBookNewPublish');
Route::get('/theo-doi-don-hang',[HomeController::class,'flowOrder'])->name('flowOrder');
Route::get('/tim-kiem/',[HomeController::class,'search'])->name('search');

Route::get('/tac-gia/{id}',[HomeController::class,'viewAuthor'])->name('viewAuthor');

Route::get('/cty-phat-hanh/{id}',[HomeController::class,'viewCompany'])->name('viewCompany');

Route::get('/trang-quan-tri',[DashBoardController::class,'index'])->name('dashboard');


Route::get('doi-mat-khau',[UserController::class,'changePassword'])->name('changePassword');
Route::post('submitPassword',[UserController::class,'submitPassword'])->name('submitPassword');




// ROUTE BACK-END

Route::get('category/list',[])->name('listCategory');
Route::get('category/list',[CategoryController::class,'show'])->name('listCategory');
Route::get('author/list',[AuthorController::class,'getlist'])->name('listAuthor');
Route::get('company/list',[CompanyController::class,'getlist'])->name('listCompany');
Route::get('slide/list',[SlideController::class,'getlist'])->name('listSlide');
Route::get('category/list',[CategoryController::class,'getlist'])->name('listCategory');

Route::get('book/list',[BookController::class,'getlist'])->name('listBook');
Route::get('order/list',[OrderController::class,'getlist'])->name('listOrder');


Route::post('book/uploadImagesBook',[BookController::class,'uploadImagesBook'])->name('uploadImagesBook');
Route::post('book/uploadAvatarBook',[BookController::class,'uploadAvatarBook'])->name('uploadAvatarBook');

Route::post('author/uploadAvatarAuthor',[AuthorController::class,'uploadAvatarAuthor'])->name('uploadAvatarAuthor');

Route::post('company/uploadCompanyLogo',[CompanyController::class,'uploadCompanyLogo'])->name('uploadCompanyLogo');
Route::post('slide/uploadSlideImage',[SlideController::class,'uploadSlideImage'])->name('uploadSlideImage');

Route::get('comment/list',[CommentController::class,'getlist'])->name('listComment');
Route::get('list-users',[UserController::class,'getList'])->name('getListUser');

Route::post('slide/order',[SlideController::class,'order'])->name('slide.order');
Route::post('category/order',[CategoryController::class,'order'])->name('submitOrderCategory');

Route::get('payment/success',[PaymentController::class,'success'])->name('payment.success');
Route::get('payment/cancel',[PaymentController::class,'cancel'])->name('payment.cancel');

Route::resource('user',UserController::class);
Route::resource('author',AuthorController::class);
Route::resource('category',CategoryController::class);
Route::resource('company',CompanyController::class);
Route::resource('slide',SlideController::class);
Route::resource('book', BookController::class);
Route::resource('comment', CommentController::class);
Route::resource('order', OrderController::class);
Route::resource('save', SaveController::class);
Route::resource('payment', PaymentController::class);

Route::post('save_add',[SaveController::class,'save_add'])->name('save_add');
Route::post('updateOrders',[OrderController::class,'updateOrders'])->name('order.updateOrders');

Route::post('cart/add',[CartController::class,'addCart'])->name('cart.add');
Route::post('cart/updateCart',[CartController::class,'updateCart'])->name('cart.updateCart');
Route::post('cart/deleteCart',[CartController::class,'deleteCart'])->name('cart.deleteCart');
Route::resource('cart',CartController::class);

