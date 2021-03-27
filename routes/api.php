<?php

use Illuminate\Support\Facades\Route;

Route::resource('users', User\UserController::class)->except(['create', 'edit']);
Route::resource('products', Product\ProductController::class)->only(['index', 'show']);
Route::resource('categories', Category\CategoryController::class)->except(['create', 'edit']);
Route::resource('transactions', Transaction\TransactionController::class)->only(['index', 'show']);
Route::resource('buyers', Buyer\BuyerController::class)->only(['index', 'show']);
Route::resource('sellers', Seller\SellerController::class)->only(['index', 'show']);
