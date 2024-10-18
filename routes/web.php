<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
Route::get('/', function () {
    return Auth::check() ? redirect()->route('home') : view('auth.register');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->name('logout');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/orders', [App\Http\Controllers\OrdersController::class, 'index'])->name('orders.index');

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/search', [OrderController::class, 'index'])->name('orders.search');

Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::resource('products', ProductController::class);
Route::patch('products/update/{id}', [ProductController::class, 'update'])->name('products.update');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');


Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
Route::resource('customers', CustomerController::class);
Route::get('/search-customers', [CustomerController::class, 'search']);
