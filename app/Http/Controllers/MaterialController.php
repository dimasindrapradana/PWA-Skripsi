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
        $category->materials_for_js = $category->materials->map(function ($m) {
            return [
                'id' => $m->id,
                'title' => $m->title,
                'slug' => $m->slug,
                'content_plain' => mb_substr(strip_tags($m->content), 0, 110),
            ];
        })->values();
    }

         // Filter jika pencarian berdasarkan kategori
    if ($search) {
        $foundCategory = \App\Models\Category::where('name', 'like', "%$search%")->first();
        if ($foundCategory) {
            $foundCategory->load('materials');
            $foundCategory->materials_for_js = $foundCategory->materials->map(function ($m) {
                return [
                    'id' => $m->id,
                    'title' => $m->title,
                    'slug' => $m->slug,
                    'content_plain' => mb_substr(strip_tags($m->content), 0, 110),
                ];
            })->values();

            $categories = collect([$foundCategory]);
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
        $material = Material::with(['category', 'tests'])->where('slug', $slug)->firstOrFail();

         if (auth()->check()) {
        $user = auth()->user();
        $user->readMaterials()->syncWithoutDetaching([
            $material->id => ['has_read' => true]
        ]);
    }
    
        $categories = \App\Models\Category::with([
            'materials' => function ($q) {
                $q->orderBy('id');
            },
            'tests' 
        ])->get();

        // Cari posisi sekarang untuk tombol sebelumnya & selanjutnya (di dalam kategori aktif saja)
        $materials = $material->category->materials;
        $currentIndex = $materials->search(fn($m) => $m->id === $material->id);
        $previous = $materials[$currentIndex - 1] ?? null;
        $next = $materials[$currentIndex + 1] ?? null;

        $hasQuiz = $material->tests && $material->tests->count() > 0;

        $readMaterialIds = auth()->check()
        ? auth()->user()->readMaterials()->pluck('material_id')->toArray()
        : [];

        return view('layouts.material', compact('material', 'categories', 'previous', 'next', 'hasQuiz', 'readMaterialIds'));

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
