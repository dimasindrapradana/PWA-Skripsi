<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class SubmissionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'link' => 'required|url',
        ]);

        Submission::create([
            'user_id' => auth()->id(),
            'material_id' => $request->material_id,
            'link' => $request->link,
            'description' => $request->description,
            'slug' => Str::uuid(),
            'submitted_at' => now(),
        ]);

        return back()->with('success', 'Tugas berhasil dikumpulkan!');
    }
}
