<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;

Route::get('/', [ProductsController::class, 'index']);
Route::post('/save', [ProductsController::class, 'save'])->name('save');
