<?php

use App\Http\Controllers\InstagramV2Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApifyController;

// Route to display the search formdwadwad
Route::get('/', [ApifyController::class, 'index']);

// Route to handle the form submission and search
Route::post('/search', [ApifyController::class, 'search'])->name('search');
Route::get('/instagram/{username}', [InstagramV2Controller::class, 'fetchData']);
// Route::get('/instagram-data/{username}', [InstagramV2Controller::class, 'fetchInstagramDataFromNode']);
Route::post('/instagram-data', [InstagramV2Controller::class, 'fetchInstagramDataFromNode'])->name('instagram-data');

