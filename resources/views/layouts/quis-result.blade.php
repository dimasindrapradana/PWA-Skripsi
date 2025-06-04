@extends('layouts.app')

@section('title', 'Hasil Kuis')

@section('content')
<div class="container mx-auto p-4 max-w-xl">
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-4 text-center text-gray-800">🎉 Hasil Kuis</h2>

        <p class="text-lg text-gray-700 mb-2">Nama: <strong>{{ auth()->user()->name }}</strong></p>
        <p class="text-lg text-gray-700 mb-2">Skor Anda: <strong>{{ $result->score }} / {{ $totalQuestions }}</strong></p>

        @php
            $percentage = ($result->score / $totalQuestions) * 100;
            $isPassed = $percentage >= 70;
        @endphp

        <p class="text-lg mt-4 font-semibold {{ $isPassed ? 'text-green-600' : 'text-red-600' }}">
            {{ $isPassed ? 'Selamat! Anda lulus kuis ini.' : 'Anda belum lulus. Silakan ulangi kuis.' }}
        </p>

        <div class="mt-6 text-center">
            <a href="{{ route('materi.show', $material->slug) }}"
                class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Kembali ke Materi
            </a>
            @unless($isPassed)
                <a href="{{ route('quiz.show', $material->slug) }}"
                    class="inline-block px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 ml-2">
                    Ulangi Kuis
                </a>
            @endunless
        </div>
    </div>
</div>
@endsection
