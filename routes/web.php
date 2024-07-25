<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApifyController;
use Illuminate\Support\Facades\Artisan;

// login
Route::get('/', [ApifyController::class, 'login'])->name('login');
Route::post('/dashboard', [ApifyController::class, 'signIn'])->name('signIn');
Route::get('/register', [ApifyController::class, 'showSignupForm'])->name('showSignupForm');
Route::post('/signup', [ApifyController::class, 'signup'])->name('signup');
Route::get('/dashboard', [ApifyController::class, 'index'])->name('dashboard');
// Route to handle the form submission and search
Route::post('/search', [ApifyController::class, 'search'])->name('search');


Route::get('/run-npm-install', function () {
    // Run npm install command
    $output = [];
    $returnVar = 0;
    exec('cd /home/devbox3/viraltest.developmentbox3.ca && npm install 2>&1', $output, $returnVar);

    // Return the output and status
    return response()->json([
        'output' => $output,
        'status' => $returnVar === 0 ? 'success' : 'error'
    ]);
});

Route::get('/install-node', function () {

    $logFile = 'C:\laragon\www\viral-findr';
    $command = 'sudo bash -c "curl -fsSL https://deb.nodesource.com/setup_16.x | bash - && apt-get install -y nodejs 2>&1"';
    exec($command . ' >> ' . $logFile . ' 2>&1', $output, $returnVar);

    // Return the output and status
    return response()->json([
        'output' => $output,
        'log' => file_get_contents($logFile),
        'status' => $returnVar === 0 ? 'success' : 'error',
        'returnVar' => $returnVar
    ]);
});
