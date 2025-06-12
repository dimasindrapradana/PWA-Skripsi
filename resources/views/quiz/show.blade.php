@extends('layouts.app')
@section('title', $test->title)

@section('content')
<div class="max-w-2xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">{{ $test->title }}</h1>
    <p class="mb-4 text-gray-600">Materi: {{ $material->title ?? '-' }}</p>
    <form action="{{ route('quiz.submit', $test->slug) }}" method="POST">
        @csrf
        @foreach($questions as $index => $question)
            <input type="hidden" name="question_ids[]" value="{{ $question->id }}">
            <div class="mb-5">
                <div class="font-semibold mb-2">{{ $index + 1 }}. {{ $question->question_text }}</div>
                @foreach ($question->options as $option)
                    <label class="block mb-1">
                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}" required>
                        {{ $option->option_text }}
                    </label>
                @endforeach
            </div>
        @endforeach
        <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded font-bold">Kumpulkan Jawaban</button>
    </form>
</div>
@endsection
