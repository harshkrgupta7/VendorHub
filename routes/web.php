<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Add this test route:
Route::get('/test', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'Laravel + Docker + MySQL working perfectly!',
        'php_version' => phpversion(),
        'laravel_version' => app()->version(),
        'database' => DB::connection()->getDatabaseName(),
    ]);
});
