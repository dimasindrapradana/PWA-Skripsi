<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterCustomController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\Auth\UserRegisterController;

// Register route
Route::get('/register-custom', [RegisterCustomController::class, 'show'])->name('register.custom.show');
Route::post('/register-custom', [RegisterCustomController::class, 'register'])->name('register.custom');

// Landing and pages
Route::get('/', fn() => view('layouts.landing'));
Route::get('/categories', fn() => view('layouts.category'));
Route::get('/introduction', fn() => view('layouts.introductionCategory'));
Route::get('/materials', fn() => view('layouts.material'));

// Quiz
Route::get('/quis', [QuizController::class, 'show'])->name('quis');
Route::post('/quis', [QuizController::class, 'submit'])->name('quis.submit');

// Dashboard user (protected route)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

Route::get('/login-siswa', [UserLoginController::class, 'showLoginForm'])->name('login.user');
Route::post('/login-siswa', [UserLoginController::class, 'login'])->name('login.user.submit');

Route::get('/register-siswa', [UserRegisterController::class, 'showRegisterForm'])->name('register.user');
Route::post('/register-siswa', [UserRegisterController::class, 'register'])->name('register.user.submit');

// Route::get('/login', fn() => redirect()->route('login.user'))->name('login');
});