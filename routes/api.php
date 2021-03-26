<?php

use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::resource('users', UserController::class)->except(['create', 'edit']);
Route::resource('products', ProductController::class)->only(['index', 'show']);
