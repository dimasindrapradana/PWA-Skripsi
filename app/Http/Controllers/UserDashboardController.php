<?php

namespace App\Http\Controllers;
use App\Models\Category;

use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
    
        $categories = Category::all();

        return view('layouts.dashboard', compact('categories')); 
    }
}
