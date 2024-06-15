<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripePayementController ;


Route::get('stripe' , [StripePayementController::class , 'stripe'])->name('strepe.get');

Route::post('stripe' , [StripePayementController::class , 'stripePost'])->name('stripe.post');