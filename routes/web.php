<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/about', 'about')->name('about');
Route::view('/features', 'features')->name('features');
Route::view('/pricing', 'pricing')->name('pricing');
Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::view('/privacy-policy', 'privacy-policy');
Route::view('/terms-of-service', 'terms-of-service');
Route::view('/website-disclaimer', 'website-disclaimer');
