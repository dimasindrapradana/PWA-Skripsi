<?php

use Illuminate\Support\Facades\Route;

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