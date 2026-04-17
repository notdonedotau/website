<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/software-development', 'software-development');
Route::view('/blesta-plugins', 'blesta-plugins');
Route::view('/contact', 'contact');
