<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/no-contracts', function () {
    return view('no-contracts');
});

Route::get('/professional-service', function () {
    return view('professional-service');
});

Route::get('/electronic-payments', function () {
    return view('electronic-payments');
});

Route::post('/request-service', [App\Http\Controllers\ServiceRequestController::class, 'store']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
