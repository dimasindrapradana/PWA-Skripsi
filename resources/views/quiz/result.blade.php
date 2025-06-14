@extends('layouts.app')
@section('title', $test->title)

@section('content')
@include('components.navbar')
@include('components.mobile-navbar')

<div class="max-w-2xl mx-auto py-8 px-2 sm:px-0 pb-28"> {{-- pb-28: ruang bawah biar tombol dan footer tidak ketutup navbar --}}
    <h1 class="text-2xl font-bold mb-5 text-slate-900">{{ $test->title }}</h1>
    <p class="mb-4 text-gray-600">Materi: {{ $material->title ?? '-' }}</p>

    {{-- Ringkasan Skor --}}
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-8 flex flex-col items-center">
        <div class="text-xl font-semibold mb-2 text-slate-900">Skor Kamu:
            <span class="{{ $result->score >= 70 ? 'text-green-600' : 'text-red-600' }}">
                {{ $result->score }}
            </span>
            / 100
        </div>
        <div class="text-sm text-slate-500">Benar: {{ $jumlah_benar }} dari {{ $jumlah_soal }} soal</div>

        @if($result->score >= 70)
            <div class="bg-green-100 text-green-800 rounded-lg px-4 py-2 text-sm font-medium mt-2 animate-bounce">
                Selamat! Kamu lulus kuis ini 🎉
            </div>
        @else
            <div class="bg-red-100 text-red-700 rounded-lg px-4 py-2 text-sm font-medium mt-2 animate-pulse">
                Skor belum cukup. Ayo coba lagi untuk dapat skor terbaik!
            </div>
        @endif
    </div>

    {{-- Daftar Soal & Jawaban --}}
    <div class="bg-white rounded-xl shadow p-4 space-y-6"> {{-- space-y-6 agar antar soal lega --}}
        @foreach($questions as $i => $question)
            @php
                $studentAnswer = $user_answers[$question->id] ?? null;
                $correctOption = $question->options->firstWhere('is_correct', true);
            @endphp
            <div class="p-4 rounded-xl border transition
                @if(!$correctOption)
                    border-yellow-300 bg-yellow-50
                @elseif($studentAnswer === $correctOption->id)
                    border-green-400 bg-green-50
                @else
                    border-red-300 bg-red-50
                @endif
                mb-2
            ">
                <div class="mb-2 font-semibold text-slate-900 flex items-center gap-2">
                    <span class="w-8 h-8 inline-flex justify-center items-center rounded-full
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
                @if($question->images && count($question->images))
                    <div class="flex flex-wrap gap-4 my-3 justify-center">
                        @foreach($question->images as $img)
                            <figure class="flex flex-col items-center">
                                <img src="{{ asset('storage/' . $img->image_url) }}"
                                    alt="{{ $img->description }}"
                                    class="rounded shadow max-h-36 max-w-[140px] object-contain mb-1 border border-gray-200">
                            </figure>
                        @endforeach
                    </div>
                @endif

                <div class="mt-2 space-y-3">
                    @foreach($question->options as $option)
                        <div class="
                            flex items-center gap-2 rounded-lg px-3 py-2
                            transition
                            @if($correctOption && $option->id == $correctOption->id)
                                bg-green-100 font-bold text-green-900
                            @elseif($studentAnswer == $option->id && (!$correctOption || $studentAnswer !== $correctOption->id))
                                bg-red-100 font-bold text-red-900
                            @else
                                bg-gray-50
                            @endif
                        ">
                            <span class="w-4 h-4 inline-block rounded-full flex-shrink-0
                                @if($correctOption && $option->id == $correctOption->id)
                                    bg-green-500
                                @elseif($studentAnswer == $option->id && (!$correctOption || $studentAnswer !== $correctOption->id))
                                    bg-red-500
                                @else
                                    bg-gray-300
                                @endif
                            "></span>
                            <span class="
                                @if($option->id == $studentAnswer) underline @endif
                                @if($option->id == ($correctOption->id ?? null)) font-bold @endif
                            ">
                                {{ $option->option_text }}
                                @if($correctOption && $option->id == $correctOption->id)
                                    <span class="ml-2 text-xs text-green-600 font-bold">(Kunci)</span>
                                @endif
                                @if($option->id == $studentAnswer && (!$correctOption || $studentAnswer !== ($correctOption->id ?? null)))
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
    <div class="flex flex-col sm:flex-row justify-center gap-3 mt-8 mb-6">
        @if($result->score < 70)
            <a href="{{ route('quiz.show', $result->test->slug) }}"
               class="bg-yellow-500 hover:bg-yellow-600 text-indigo-900 font-bold px-6 py-3 rounded-xl shadow transition text-center">
                Coba Lagi dengan Soal Berbeda
            </a>
        @endif
        <a href="{{ route('quiz.index') }}"
            class="bg-gray-100 hover:bg-gray-200 text-slate-900 font-semibold px-6 py-3 rounded-xl shadow transition text-center">
            Kembali ke Daftar Kuis
        </a>
    </div>
</div>
@endsection
