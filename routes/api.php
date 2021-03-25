<?php

use Illuminate\Support\Facades\Route;

Route::resource('users', User\UserController::class)->except(['create', 'edit']);
