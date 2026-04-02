<?php

use App\Http\Controllers\Admin\AdminBrandController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminLogController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminSpecificationController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::view('/contact', 'pages.contact')->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::view('/author', 'pages.author')->name('author');

Route::middleware('CheckGuest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.store');
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.store');
});


// add/delete/update cart || checkout/orders
Route::middleware('CheckAuth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/promo', [CartController::class, 'promoCode'])->name('cart.promo');
    Route::patch('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/order/confirmation/{id}', [OrderController::class, 'confirmation'])->name('order.confirmation');
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.index');
    Route::patch('/my-orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password');

});

// Admin
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function() {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', AdminProductController::class);
    Route::delete('/images/{id}', [AdminProductController::class, 'deleteImage'])->name('images.delete');
    Route::patch('/images/{id}/primary', [AdminProductController::class, 'setPrimaryImage'])->name('images.primary');

    Route::resource('categories', AdminCategoryController::class);
    Route::resource('brands', AdminBrandController::class);
    Route::resource('specifications', AdminSpecificationController::class);
    Route::resource('orders', AdminOrderController::class)->except(['create', 'store']);
    Route::resource('users', AdminUserController::class)->except(['create', 'store']);
    Route::patch('/users/{id}/ban', [AdminUserController::class, 'ban'])->name('users.ban');
    Route::resource('logs', AdminLogController::class)->only(['index', 'destroy']);
    Route::delete('logs', [AdminLogController::class, 'clearAll'])->name('logs.clear');

});
