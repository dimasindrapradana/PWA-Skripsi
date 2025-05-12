<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuizController extends Controller
{
    // Menampilkan form kuis
    public function show()
    {
        return view('layouts.quis');
    }

    // Proses jawaban dan hitung skor
    public function submit(Request $request)
{
    $correctAnswers = [
        1 => ['question' => 'Apa ibukota Indonesia?', 'correct' => 'Jakarta', 'options' => ['Surabaya', 'Jakarta', 'Bandung', 'Medan']],
        2 => ['question' => '2 + 2 = ?', 'correct' => '4', 'options' => ['3', '4', '5', '6']],
    ];

    $userAnswers = $request->input('answer', []);
    $results = [];
    $score = 0;

    foreach ($correctAnswers as $index => $data) {
        $selected = $userAnswers[$index] ?? null;
        $isCorrect = $selected === $data['correct'];
        if ($isCorrect) $score++;

        $results[] = [
            'question' => $data['question'],
            'options' => $data['options'],
            'correct' => $data['correct'],
            'selected' => $selected,
        ];
    }

    return view('layouts.quis-result', [
        'results' => $results,
        'score' => $score,
        'total' => count($correctAnswers),
    ]);
}

}
