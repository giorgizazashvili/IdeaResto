<?php

use App\Http\Controllers\KitchenController;
use App\Http\Controllers\OrderReceiptController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('app');
});

// სამზარეულოს ეკრანი - ავტორიზაციით დაცული
Route::middleware(['auth'])->group(function () {
    Route::get('/kitchen', [KitchenController::class, 'index'])->name('kitchen.display');
    Route::post('/kitchen/update-status/{order}', [KitchenController::class, 'updateStatus'])->name('kitchen.update-status');

    // შეკვეთის ანგარიში/ჩეკი
    Route::get('/orders/{order}/receipt', [OrderReceiptController::class, 'show'])->name('orders.receipt');
});