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

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/product/{id}', [PageController::class, 'detailProduct'])->name('detail_product');
Route::post('/product/{id}', [PageController::class, 'cartProduct']);
Route::get('cart', [PageController::class, 'cart'])->name('cart');


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
Route::get('/users', [UsersController::class, 'index'])->name('users');
Route::get('/users/{id}/activate', [UsersController::class, 'activate'])->name('users.activate');
Route::get('/users/{id}/deactivate', [UsersController::class, 'deactivate'])->name('users.deactivate');
Route::get('/products', [ProductsController::class, 'index'])->name('products');

Route::get('/add-product', [ProductsController::class, 'create'])->name('add-product');
Route::post('/add-product', [ProductsController::class, 'store']);

Route::get('/update-kriteria/{id}', [ProductsController::class, 'EditKriteria'])->name('update-kriteria');
Route::post('/update-kriteria/{id}', [ProductsController::class, 'UpdateKriteria']);

