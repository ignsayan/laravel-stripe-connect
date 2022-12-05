<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\ConnectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::controller(CashierController::class)->group(function () {
    Route::get('payments', 'index')->name('payments');
    Route::post('payments', 'savePaymentMethod');
    Route::get('saved-card', 'cardDetails')->name('saved-card');
    Route::get('set-default/{id}', 'changeDefaultMethod')->name('set-default');
    Route::get('remove-card/{id}', 'removePaymentMethod')->name('remove-card');
    Route::get('add-balance', 'addBalance')->name('add-balance');
    Route::get('charge/{amount}', 'chargeUser')->name('charge');
});

Route::controller(ConnectController::class)->group(function () {
    Route::get('users', 'getUserDetails')->name('users');
    Route::get('onboard/{uuid}', 'handleBoardingRedirect')->name('onboard');
    Route::get('transfer/{uuid}', 'transferPage')->name('transfer');
    Route::post('transfer', 'transferPayoutAmount')->name('post.transfer');
});

Route::controller(AccountController::class)->group(function () {
    Route::get('bank-accounts', 'index')->name('bank-accounts');
    Route::post('bank-accounts', 'setDefault');
    Route::get('add-account', 'addAccount')->name('add-account');
    Route::post('add-account', 'storeAccount');
});
