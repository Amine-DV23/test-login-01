<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\BoposController;
use App\Models\Bopos;


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


Route::get('/welcome', function () {
    $bopos = Bopos::all();
    return view('welcome', compact('bopos'));
})->name('welcome');



Route::get('/admin/products', function () {
    return view('adminProduct');
})->name('admin.products');


Route::post('/admin/products/store', function (Illuminate\Http\Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    Bopos::create([
        'name' => $request->input('name'),
    ]);

    return redirect()->route('admin.products')->with('success', 'تم إضافة المنتج بنجاح!');
})->name('admin.products.store');


Route::post('/bopos', [BoposController::class, 'store'])->name('bopos.store');
use App\Http\Controllers\OrderController;

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
