<?php

use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

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

Route::controller(PageController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/product/{id}', 'detailProduct')->name('detail_product');
    Route::post('/product/{id}', 'cartProduct');
    Route::get('cart', 'cart')->name('cart');
    Route::get('/cart/{id}', 'removeFromCart')->name('remove_from_cart');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'daftar');
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'masuk');
    Route::get('/logout', 'logout')->name('logout');
});

Route::get('/dashboard', function () {
    return view('pages.admin.dashboard');
})->name('dashboard');

Route::controller(UsersController::class)->group(function () {
    Route::get('/users', 'index')->name('users');
    Route::get('/users/{id}/change-status', 'changeStatus')->name('change_status_user');
    Route::get('/users/add-user', 'create')->name('add-user');
});

Route::controller(ProductsController::class)->group(function () {
    Route::get('/products', 'index')->name('products');

    Route::get('image/{path}', 'show')->where('path', '.*')->name('image.show');
    // Route::get('/product-image/{id}', 'showImage'])
    //     ->name('product.image');

    Route::get('/products/{id}/edit', 'edit')->name('edit-product');
    Route::put('/products/{id}', 'update')->name('update-product');

    Route::get('/add-product', 'create')->name('add-product');
    Route::post('/add-product', 'store');

    Route::get('/update-kriteria/{id}', 'EditKriteria')->name('update-kriteria');
    Route::post('/update-kriteria/{id}', 'UpdateKriteria');

    Route::get('/detail-product/{id}', 'detailProduct')->name('detailProduct');
});
