<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;


Route::get('/', function () {
    return view('login');
});


// Route::get('/login', [LoginController::class, 'index'])->name('login');
