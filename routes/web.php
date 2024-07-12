<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApifyController;

// Route to display the search form
Route::get('/', [ApifyController::class, 'index']);

// Route to handle the form submission and search
Route::post('/search', [ApifyController::class, 'search'])->name('search');
