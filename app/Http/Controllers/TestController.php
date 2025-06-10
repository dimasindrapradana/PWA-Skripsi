<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Test;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class TestController extends Controller
{
    public function show($slug)
    {
        $material = Material::where('slug', $slug)
            ->with('tests.questions.options')
            ->firstOrFail();

        $test = $material->tests->firstOrFail();

        // Jika user sudah mengerjakan kuis, redirect ke hasil
        // $existingResult = Result::where('test_id', $test->id)
        //     ->where('user_id', Auth::id())
        //     ->latest()
        //     ->first();

        // if ($existingResult) {
        //     return redirect()->route('quiz.result', $existingResult->slug);
        // }

        // // Simpan waktu mulai kuis (hanya sekali)
        // if (!session()->has("quiz_started_at.{$test->id}")) {
        //     session(["quiz_started_at.{$test->id}" => now()]);
        // }

        return view('layouts.quis', compact('test', 'material'));
        }

    public function submit(Request $request, $slug)
    {
        $material = Material::where('slug', $slug)
            ->with('tests.questions.options')
            ->firstOrFail();

        // Ambil test yang pertama (asumsi 1 materi 1 kuis)
        $test = $material->tests->firstOrFail();

        $answers = $request->input('answers', []);
        $score = 0;

        foreach ($test->questions as $question) {
            $correct = $question->options->firstWhere('is_correct', true);
            if (isset($answers[$question->id]) && $answers[$question->id] == $correct->id) {
                $score++;
            }
        }

        // Simpan result (misal pakai slug unik)
        $result = Result::create([
            'test_id' => $test->id,
            'user_id' => Auth::id(),
            'score' => $score,
            'submitted_at' => now(),
        ]);

        dd($material->tests);

        return redirect()->route('quiz.result', ['slug' => $result->slug])
            ->with('success', 'Kuis telah diselesaikan!');
    }


        public function result($slug)
        {
            $result = Result::with('test.material') // Eager load material
                ->where('slug', $slug)
                ->where('user_id', Auth::id())
                ->first();

            if (!$result) {
                // Fallback: Coba cari berdasarkan ID lama
                $result = Result::find($slug);
                
                if ($result) {
                    return redirect()->route('quiz.result', $result->slug);
                }
                
                abort(404, 'Hasil kuis tidak ditemukan');
            }

            $material = $result->test->material;
            $totalQuestions = $result->test->questions()->count();

            return view('layouts.quis-result', compact('result', 'material', 'totalQuestions'));
        }

        

}
