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
        $material = Material::where('slug', $slug)->with('tests.questions.options')->firstOrFail();
        $test = $material->tests->firstOrFail();

        $answers = $request->input('answers', []);
        $score = 0;

        foreach ($test->questions as $question) {
            $correct = $question->options->firstWhere('is_correct', true);
            if (isset($answers[$question->id]) && $answers[$question->id] == $correct->id) {
                $score++;
            }
        }

        $result = Result::create([
            'test_id' => $test->id,
            'user_id' => Auth::id(),
            'score' => $score,
            'submitted_at' => now(),
        ]);

        return redirect()->route('quiz.result', ['resultSlug' => $result->slug])
        ->with('success', 'Kuis telah diselesaikan!');
        }

        public function result($resultSlug)
        {
              $result = Result::with('test')
                ->where('slug', $resultSlug)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $material = $result->test->material;
            $totalQuestions = $result->test->questions()->count();

            return view('layouts.quis-result', compact('result', 'material', 'totalQuestions'));
        }

}
