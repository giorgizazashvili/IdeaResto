<?php

use App\Http\Controllers\KitchenController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('app');
});

// სამზარეულოს ეკრანი
Route::get('/kitchen', [KitchenController::class, 'index'])->name('kitchen.display');
Route::post('/kitchen/update-status/{order}', [KitchenController::class, 'updateStatus'])->name('kitchen.update-status');