<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    // Halaman daftar semua kuis
    public function index(Request $request)
    {
         $query = \App\Models\Test::with('material');

    // Filter search
    if ($search = $request->input('q')) {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhereHas('material', function ($q2) use ($search) {
                  $q2->where('title', 'like', "%{$search}%");
              });
        });
    }

        $tests = $query->get();


         $userResults = \App\Models\Result::where('user_id', Auth::id())
        ->get()
        ->keyBy('test_id');

   
        $categories = \App\Models\Category::whereHas('materials.tests')->get();

     $readMaterialIds = auth()->check()
        ? auth()->user()->readMaterials()->pluck('material_id')->toArray()
        : [];

   
    return view('quiz.index', compact('tests', 'userResults', 'categories', 'readMaterialIds'));
    }

    // Halaman detail & pengerjaan kuis
    public function show($slug)
    {
        $test = Test::where('slug', $slug)
            ->with(['questions.options', 'material'])
            ->firstOrFail();

        $material = $test->material;
        $user = auth()->user();

    // CEK apakah user sudah membaca materi terkait (dari tabel pivot)
        $hasRead = $user->readMaterials()
            ->where('material_id', $material->id)
            ->wherePivot('has_read', true)
            ->exists();

        if (! $hasRead) {
            return redirect()->route('materi.show', $material->slug)
                ->with('error', 'Silakan pelajari materi terlebih dahulu sebelum mengerjakan kuis.');
        }
        $questions = $test->questions->shuffle()->take(10);

        $material = $test->material;
        return view('quiz.show', compact('test', 'material', 'questions'));
    }

    public function submit(Request $request, $slug)
    {
        $test = Test::where('slug', $slug)
        ->with(['questions.options', 'material'])
        ->firstOrFail();

      
        $questionIds = $request->input('question_ids', []);
        $answers = $request->input('answers', []);
        $jumlah_soal = count($questionIds);

        $questions = $test->questions()->whereIn('id', $questionIds)->with('options')->get();

        $jumlah_benar = 0;

                foreach ($questions as $question) {
                $correct = $question->options->firstWhere('is_correct', true);
                if ($correct && isset($answers[$question->id]) && $answers[$question->id] == $correct->id) {
                    $jumlah_benar++;
                }
            }

        $score = $jumlah_soal > 0 ? $jumlah_benar * (100 / $jumlah_soal) : 0;

        $result = Result::create([
            'test_id' => $test->id,
            'user_id' => Auth::id(),
            'score' => round($score),
            'submitted_at' => now(),
        ]);

        session(['user_answers_' . $result->id => $answers, 'user_questions_' . $result->id => $questionIds]);

        return redirect()->route('quiz.result', ['slug' => $result->slug])
            ->with('success', 'Kuis telah diselesaikan!');
    }

    // Halaman hasil kuis
    public function result($slug)
    {
        $result = Result::with('test.material')->where('slug', $slug)->where('user_id', Auth::id())->firstOrFail();
        $test = $result->test;
        $material = $test->material;

        $questionIds = session('user_questions_' . $result->id, []);
        $user_answers = session('user_answers_' . $result->id, []);

        // Ambil & urutkan soal sesuai urutan pengerjaan
        $questionsDb = $test->questions()->whereIn('id', $questionIds)->with('options')->get();
        $questions = collect($questionIds)->map(function ($id) use ($questionsDb) {
            return $questionsDb->firstWhere('id', $id);
        });

        $jumlah_soal = count($questionIds);
        $jumlah_benar = 0;
        foreach ($questions as $question) {
            $correct = $question->options->firstWhere('is_correct', true);
            if ($correct && isset($user_answers[$question->id]) && $user_answers[$question->id] == $correct->id) {
                $jumlah_benar++;
            }
        }

        return view('quiz.result', compact(
            'result', 'material', 'jumlah_benar', 'jumlah_soal', 'test', 'user_answers', 'questions'
        ));
    }
        public function autocomplete(Request $request)
        {
            $query = $request->get('q', '');

            // Ambil kuis yang judul atau judul materi terkait mengandung keyword
            $tests = \App\Models\Test::with('material.category')
                ->where('title', 'like', '%' . $query . '%')
                ->orWhereHas('material', function ($q) use ($query) {
                    $q->where('title', 'like', '%' . $query . '%');
                })
                ->limit(7)
                ->get();

            // Ambil kategori juga (opsional)
            $categories = \App\Models\Category::where('name', 'like', '%' . $query . '%')
                ->limit(3)->get();

            $results = [];

            foreach ($categories as $cat) {
                $results[] = [
                    'type' => 'kategori',
                    'label' => $cat->name,
                    'id' => $cat->id,
                    // optional: link ke daftar kuis per kategori
                ];
            }
            foreach ($tests as $test) {
                $results[] = [
                    'type' => 'kuis',
                    'label' => $test->title,
                    'id' => $test->id,
                    // optional: link ke kuis
                ];
            }

            return response()->json($results);
        }

}

