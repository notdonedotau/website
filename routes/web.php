<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DocsController;
use App\Http\Controllers\GetStartedController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/about', 'about')->name('about');
Route::view('/pricing', 'pricing')->name('pricing');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}/og-image', [BlogController::class, 'ogImage'])->name('blog.og-image');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/docs', [DocsController::class, 'index'])->name('docs.index');
Route::get('/docs/{slug}', [DocsController::class, 'show'])->name('docs.show');
Route::get('/get-started', [GetStartedController::class, 'create'])->name('get-started');
Route::post('/get-started', [GetStartedController::class, 'store'])->name('get-started.store');
Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::view('/privacy-policy', 'privacy-policy');
Route::view('/terms-of-service', 'terms-of-service');
Route::view('/website-disclaimer', 'website-disclaimer');
