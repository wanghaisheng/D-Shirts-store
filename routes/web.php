<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\CustomersController;
use App\Http\Controllers\Admin\RevenueController;
use App\Http\Controllers\Admin\TshirtsController;
use App\Http\Controllers\Customer\HomePageController;
use App\Http\Controllers\Customer\TshirtsController as CustomerTshirtsController;

// ################################ Customer Routes ################################
Route::get('/', [HomePageController::class, 'index'])->name('home');

Route::get('/privacy-policy', function () {
    return Inertia::render('Customer/PrivacyPolicy');
})->name('privacy-policy');

Route::get('/terms-of-use', function () {
    return Inertia::render('Customer/TermsOfUse');
})->name('terms-of-use');

Route::redirect('/t-shirt', '/');
Route::get('/t-shirt/{slug}', [CustomerTshirtsController::class, 'tshirtPage'])->name('tshirt.page');



// ############################### Admin Routes ###############################
Route::prefix('admin')->middleware('auth')->group(function () {
    // orders
    Route::get('orders', [OrdersController::class, 'index'])->name('orders');
    Route::put('orders/{order}', [OrdersController::class, 'update'])->name('orders.update');

    // customers
    Route::get('customers', [CustomersController::class, 'index'])->name('customers');

    // t-shirts 
    Route::get('t-shirts', [TshirtsController::class, 'index'])->name('t-shirts');
    Route::post('t-shirts', [TshirtsController::class, 'store'])->name('t-shirts.store');
    Route::post('t-shirts/{tshirt}', [TshirtsController::class, 'update'])->name('t-shirts.update');
    Route::delete('t-shirts/{tshirt}', [TshirtsController::class, 'destroy'])->name('t-shirts.destroy');

    // revenue
    Route::get('revenue', [RevenueController::class, 'index'])->name('revenue');
});
Route::redirect('/dashboard', '/admin/orders')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ################################ Auth Routes ################################
require __DIR__ . '/auth.php';
