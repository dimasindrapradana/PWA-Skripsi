<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
        // if (auth()->user()->role !== 'user') {
        //     abort(403);
        // }

        return view('layouts.dashboard'); // pastikan file ini ada
    }
}
