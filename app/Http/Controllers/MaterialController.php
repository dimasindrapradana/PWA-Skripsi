<?php

namespace App\Http\Controllers;
use App\Models\Material;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;

class MaterialController extends Controller
{
     public function show($slug)
{
    $material = Material::with(['category.materials'])->where('slug', $slug)->firstOrFail();

    // Tandai sebagai sudah dibaca
    auth()->user()->materials()->syncWithoutDetaching([
        $material->id => ['has_read' => true]
    ]);

    // Ambil semua materi dalam kategori untuk navigasi
    $materials = $material->category->materials;

    $currentIndex = $materials->search(function ($m) use ($material) {
        return $m->id === $material->id;
    });

    $previous = $materials[$currentIndex - 1] ?? null;
    $next = $materials[$currentIndex + 1] ?? null;

    return view('layouts.material', compact('material', 'materials', 'previous', 'next'));
}

}
