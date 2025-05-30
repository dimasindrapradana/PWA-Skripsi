<?php

namespace App\Http\Controllers;
use App\Models\Material;

use Illuminate\Http\Request;

class MaterialController extends Controller
{
     public function show($slug)
    {
        $material = Material::with(['category.materials'])->where('slug', $slug)->firstOrFail();

        // Ambil semua materi di kategori terkait
        $materials = $material->category->materials;

        // Cek posisi materi saat ini untuk navigasi next & previous
        $currentIndex = $materials->search(function ($m) use ($material) {
            return $m->id === $material->id;
        });

        $previous = $materials[$currentIndex - 1] ?? null;
        $next = $materials[$currentIndex + 1] ?? null;

        return view('layouts.material', compact('material', 'materials', 'previous', 'next'));
    }
}
