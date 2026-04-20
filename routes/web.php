<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/software-development', 'software-development');
Route::view('/brands', 'brands');
Route::view('/contact', 'contact');
Route::view('/privacy-policy', 'privacy-policy');
Route::view('/terms-of-service', 'terms-of-service');
Route::view('/website-disclaimer', 'website-disclaimer');
