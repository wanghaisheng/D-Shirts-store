<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\CustomersController;
use App\Http\Controllers\Admin\RevenueController;
use App\Http\Controllers\Admin\TshirtsController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\HomePageController;
use App\Http\Controllers\Customer\PaymentController;
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

Route::get('/cart', [CartController::class, 'cartPage'])->name('cart');
Route::post('/cart', [CartController::class, 'addToCart'])->name('cart.add');
Route::delete('/cart', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/increaseQuantity', [CartController::class, 'increaseQuantity'])->name('cart.increaseQuantity');
Route::post('/cart/decreaseQuantity', [CartController::class, 'decreaseQuantity'])->name('cart.decreaseQuantity');

Route::post('/cart/checkout', [PaymentController::class, 'checkout'])->name('cart.checkout');
Route::get('/thank-you', [PaymentController::class, 'thankYouPage'])->name('thankYou');
Route::get('/failed-payment', [PaymentController::class, 'failedPaymentPage'])->name('failedPayment');
Route::post('/webhook', [PaymentController::class, 'webhook'])->name('webhook');

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

// ################################ Auth Routes ################################
require __DIR__ . '/auth.php';