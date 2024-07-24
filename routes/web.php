<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApifyController;
use Illuminate\Support\Facades\Artisan;

// Route to display the search form
Route::get('/', [ApifyController::class, 'index']);

// Route to handle the form submission and search
Route::post('/search', [ApifyController::class, 'search'])->name('search');


Route::get('/run-npm-install', function () {
    // Run npm install command
    $output = [];
    $returnVar = 0;
    exec('cd C:\laragon\www\viral-findr && npm install 2>&1', $output, $returnVar);

    // Return the output and status
    return response()->json([
        'output' => $output,
        'status' => $returnVar === 0 ? 'success' : 'error'
    ]);
});
