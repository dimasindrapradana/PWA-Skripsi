@extends('layouts.app')

@section('title', 'Hasil Kuis - ' . $test->title)

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col items-center justify-center p-4">
    <div class="max-w-2xl w-full bg-white shadow-xl rounded-2xl p-8 mt-6">
        <div class="flex items-center gap-3 mb-6">
            @if ($score >= $test->pass_score)
                <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 text-sm font-semibold rounded-full">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    Lulus!
                </span>
            @else
                <span class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 text-sm font-semibold rounded-full">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Belum Lulus
                </span>
            @endif
            <h1 class="text-xl font-bold text-slate-800">Hasil Kuis: {{ $test->title }}</h1>
        </div>

        <div class="mb-8">
            <div class="flex flex-wrap gap-6 items-center">
                <div class="text-3xl font-bold text-blue-700">{{ $score }} / 100</div>
                <div class="text-sm text-gray-700">
                    Benar: <span class="font-bold text-green-600">{{ $correct_count }}</span> /
                    Salah: <span class="font-bold text-red-600">{{ $wrong_count }}</span> <br>
                    Passing Grade: <span class="font-bold">{{ $test->pass_score }}</span>
                </div>
            </div>
        </div>

        @if ($score >= $test->pass_score)
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 font-semibold">
                Selamat, kamu dinyatakan <b>LULUS</b> pada kuis ini!
            </div>
        @else
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 font-semibold">
                Mohon ulangi kuis. Pastikan memahami materi sebelum mencoba lagi.
            </div>
        @endif

        {{-- Daftar Soal dan Jawaban --}}
        <div class="mb-8">
            @foreach($test->questions as $index => $question)
                <div class="mb-5">
                    <div class="font-semibold mb-1 text-gray-900">{{ $index+1 }}. {{ $question->question_text }}</div>
                    @if ($question->image)
                        <div class="my-2">
                            <img src="{{ asset('storage/' . $question->image) }}" class="max-w-xs rounded shadow">
                        </div>
                    @endif
                    <div class="space-y-1">
                        @foreach ($question->options as $option)
                            @php
                                $isCorrect = $option->is_correct;
                                $isUser = (isset($user_answers[$question->id]) && $user_answers[$question->id] == $option->id);
                            @endphp
                            <div class="
                                px-3 py-1 rounded border
                                {{ $isCorrect ? 'border-green-400 bg-green-50 text-green-900' : '' }}
                                {{ $isUser && !$isCorrect ? 'border-red-300 bg-red-50 text-red-700' : '' }}
                                {{ !$isUser && !$isCorrect ? 'border-slate-200 bg-white text-slate-800' : '' }}
                                flex items-center gap-2
                            ">
                                @if ($isCorrect)
                                    <span class="inline-block w-4 h-4 rounded-full bg-green-400 text-white text-xs flex items-center justify-center">✔</span>
                                @elseif ($isUser)
                                    <span class="inline-block w-4 h-4 rounded-full bg-red-400 text-white text-xs flex items-center justify-center">×</span>
                                @else
                                    <span class="inline-block w-4 h-4"></span>
                                @endif
                                <span>{{ $option->option_text }}</span>
                                @if ($isUser)
                                    <span class="ml-2 text-xs font-medium">(Jawaban Kamu)</span>
                                @endif
                                @if ($isCorrect)
                                    <span class="ml-2 text-xs font-medium">(Kunci Jawaban)</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex flex-col sm:flex-row gap-4 justify-between mt-8">
            <a href="{{ route('materi.show', $material->slug) }}"
                class="w-full sm:w-auto bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-semibold text-center transition">
                Kembali ke Materi
            </a>
            @if ($score < $test->pass_score)
                <a href="{{ route('quiz.show', $material->slug) }}"
                    class="w-full sm:w-auto bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg font-semibold text-center transition">
                    Ulangi Kuis
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
