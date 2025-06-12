@extends('layouts.app')
@section('title', $test->title)

@section('content')
<div class="max-w-2xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">{{ $test->title }}</h1>
    <p class="mb-4 text-gray-600">Materi: {{ $material->title ?? '-' }}</p>

    {{-- Ringkasan Skor --}}
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-6 flex flex-col items-center">
        <div class="text-xl font-semibold mb-2">Skor Kamu:
            <span class="{{ $result->score >= 70 ? 'text-green-600' : 'text-red-600' }}">
                {{ $result->score }}
            </span>
            / 100
        </div>
        <div class="text-sm text-slate-500">Benar: {{ $jumlah_benar }} dari {{ $jumlah_soal }} soal</div>

        @if($result->score >= 70)
            <div class="bg-green-100 text-green-800 rounded-lg px-4 py-2 text-sm font-medium mt-2">
                Selamat! Kamu lulus kuis ini 🎉
            </div>
        @else
            <div class="bg-red-100 text-red-700 rounded-lg px-4 py-2 text-sm font-medium mt-2">
                Skor belum cukup. Ayo coba lagi untuk dapat skor terbaik!
            </div>
        @endif

    </div>

    {{-- Daftar Soal & Jawaban --}}
    <div class="bg-white rounded-xl shadow p-4 space-y-5">
        @foreach($questions as $i => $question)
            @php
                $studentAnswer = $user_answers[$question->id] ?? null;
                $correctOption = $question->options->firstWhere('is_correct', true);
            @endphp
            <div class="p-4 rounded-lg border
                @if(!$correctOption)
                    border-yellow-300 bg-yellow-50
                @elseif($studentAnswer === $correctOption->id)
                    border-green-300 bg-green-50
                @else
                    border-red-300 bg-red-50
                @endif
            ">
                <div class="mb-1 font-semibold text-gray-800 flex items-center gap-2">
                    <span class="w-7 h-7 inline-flex justify-center items-center rounded-full
                        @if(!$correctOption)
                            bg-yellow-500 text-white
                        @elseif($studentAnswer === $correctOption->id)
                            bg-green-500 text-white
                        @else
                            bg-red-500 text-white
                        @endif
                    ">
                        {{ $i+1 }}
                    </span>
                    <span>{{ $question->question_text }}</span>
                </div>
                @if($question->image)
                    <img src="{{ asset('storage/' . $question->image) }}" class="my-2 max-w-xs rounded shadow">
                @endif

                <div class="mt-2 space-y-1">
                    @foreach($question->options as $option)
                        <div class="flex items-center gap-2">
                            <span class="w-4 h-4 inline-block rounded-full
                                @if($correctOption && $option->id == $correctOption->id)
                                    bg-green-500
                                @elseif($studentAnswer == $option->id && (!$correctOption || $studentAnswer !== $correctOption->id))
                                    bg-red-500
                                @else
                                    bg-gray-300
                                @endif
                            "></span>
                            <span class="
                                @if($option->id == $studentAnswer) font-bold underline @endif
                                @if($option->id == ($correctOption->id ?? null)) text-green-700 @endif
                                @if($option->id == $studentAnswer && $studentAnswer !== ($correctOption->id ?? null)) text-red-700 @endif
                            ">
                                {{ $option->option_text }}
                                @if($correctOption && $option->id == $correctOption->id)
                                    <span class="ml-2 text-xs text-green-600 font-bold">(Kunci)</span>
                                @endif
                                @if($option->id == $studentAnswer && (!$correctOption || $studentAnswer !== $correctOption->id))
                                    <span class="ml-2 text-xs text-red-600 font-bold">(Jawabanmu)</span>
                                @endif
                            </span>
                        </div>
                    @endforeach
                </div>
                @if(!$correctOption)
                    <div class="text-xs text-yellow-700 mt-2 font-semibold">Peringatan: Soal ini belum ada kunci jawaban!</div>
                @endif
            </div>
        @endforeach
    </div>

    {{-- Tombol Ulangi (jika skor rendah) --}}
    @if($result->score < 70)
    <div class="flex justify-center mt-6">
        <a href="{{ route('quiz.show', $result->test->slug) }}"
           class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-3 rounded-xl shadow transition">
            Coba Lagi dengan Soal Berbeda
        </a>
    </div>
    @endif
    @if($result->score >= 70)
            <div class="flex justify-center mt-6">
                <a href="{{ route('quiz.index') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl shadow transition">
                    Kembali ke Daftar Kuis
                </a>
            </div>
    @endif
</div>
@endsection
