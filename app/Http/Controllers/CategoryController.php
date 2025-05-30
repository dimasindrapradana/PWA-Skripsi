<?php

namespace App\Http\Controllers;
use App\Models\Category;


use Illuminate\Http\Request;

class CategoryController extends Controller
{
     public function show($slug)
    {
        $category = Category::with('materials')->where('slug', $slug)->firstOrFail();

        return view('layouts.category', compact('category'));
    }
}
