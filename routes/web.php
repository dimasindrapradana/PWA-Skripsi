<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;

Route::get('/', function () {
    return view('layouts.landing');
});

Route::get('/categories', function () {
    return view('layouts.category');
});

Route::get('/dashboard', function () {
    return view('layouts.dashboard');
});

Route::get('/introduction', function () {
    return view('layouts.introduction');
});

Route::get('/materials', function () {
    return view('layouts.material');
});

Route::get('/quis', function () {
    return view('layouts.quis');
});

Route::get('/quis', [QuizController::class, 'show'])->name('quis');
Route::post('/quis', [QuizController::class, 'submit'])->name('quis.submit');
