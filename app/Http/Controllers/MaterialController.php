<?php

namespace App\Http\Controllers;
use App\Models\Material;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categories = \App\Models\Category::with(['materials' => function($q) use ($search) {
            if ($search) {
                $q->where('title', 'like', "%$search%");
            }
        }])->get();

        foreach ($categories as $category) {
            $category->materials->transform(function ($material) {
                $material->content_plain = trim(strip_tags($material->content));
                return $material;
            });
        }

        if ($search) {
            $foundCategory = \App\Models\Category::where('name', 'like', "%$search%")->first();
            if ($foundCategory) {
                $categories = collect([$foundCategory->load('materials')]);
            } else {
                
                $categories = $categories->filter(fn($cat) => $cat->materials->count() > 0);
            }
        }

        return view('materials.index', [
            'categories' => $categories,
            'search' => $search,
        ]);
    }
    public function show($slug)
    {
        $material = Material::with(['category.materials', 'tests'])->where('slug', $slug)->firstOrFail();


        // Ambil semua materi dalam kategori untuk navigasi
        $materials = $material->category->materials;

        $currentIndex = $materials->search(function ($m) use ($material) {
            return $m->id === $material->id;
        });

        $previous = $materials[$currentIndex - 1] ?? null;
        $next = $materials[$currentIndex + 1] ?? null;

        // Cek apakah materi ini punya quiz (test)
        $hasQuiz = $material->tests && $material->tests->count() > 0;

        return view('layouts.material', compact('material', 'materials', 'previous', 'next', 'hasQuiz'));
    }
    public function autocomplete(Request $request)
    {
        $term = $request->input('term', '');

        // Cari materi
        $materials = \App\Models\Material::where('title', 'like', "%{$term}%")
            ->limit(5)->get(['title']);

        // Cari kategori
        $categories = \App\Models\Category::where('name', 'like', "%{$term}%")
            ->limit(5)->get(['name']);

        $results = [];
        foreach ($categories as $cat) {
            $results[] = ['label' => $cat->name, 'type' => 'kategori'];
        }
        foreach ($materials as $mat) {
            $results[] = ['label' => $mat->title, 'type' => 'materi'];
        }

        return response()->json($results);
    }

}
