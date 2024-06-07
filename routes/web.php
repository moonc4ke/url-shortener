<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlController;

Route::get('/', [UrlController::class, 'index'])->name('home');
Route::post('/shorten', [UrlController::class, 'shorten']);
Route::get('/{hash}', [UrlController::class, 'redirect']);
