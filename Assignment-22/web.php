<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PromotionalEmailController;


Route::get('/', function () {
    return view('welcome');
});
Route::resource('customers', CustomerController::class);


Route::get('send-promotional-email', [PromotionalEmailController::class, 'showForm'])->name('send.promotional.email.form');
Route::post('send-promotional-email', [PromotionalEmailController::class, 'sendEmail'])->name('send.promotional.email');


