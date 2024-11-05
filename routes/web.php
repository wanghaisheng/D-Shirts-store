<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\CustomersController;
use App\Http\Controllers\Admin\RevenueController;
use App\Http\Controllers\Admin\TshirtsController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('welcome');

Route::redirect('/dashboard', '/admin/orders')->name('dashboard');

Route::prefix('admin')->middleware('auth')->group(function(){
    // orders
    Route::get('orders', [OrdersController::class, 'index'])->name('orders');
    Route::put('orders/{order}', [OrdersController::class, 'update'])->name('orders.update');

    // customers
    Route::get('customers', [CustomersController::class, 'index'])->name('customers');

    // t-shirts 
    Route::get('t-shirts', [TshirtsController::class, 'index'])->name('t-shirts');  

    // revenue
    Route::get('revenue', [RevenueController::class, 'index'])->name('revenue');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
