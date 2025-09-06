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
