<?php

use App\Http\Controllers\GoogleCalendarController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/pay-now', [OrdersController::class, 'captureOrder'])->name('pay-now');

    Route::get('/pay', [PaymentController::class, 'index']);
    Route::post('/create-order', [PaymentController::class, 'createOrder'])->name('create.order');
    Route::post('/verify-payment', [PaymentController::class, 'verifyPayment'])->name('verify.payment');
    Route::get('/thank-you-payment/{purchase_order_id}', [PaymentController::class, 'thankYouPayment'])->name('thank-you-payment');

});
