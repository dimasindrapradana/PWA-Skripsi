@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4">

    <div class="quiz-alert">
    <p class="text-lg font-semibold">❗ Try again once you are ready</p>
    <div class="mt-2 text-sm">
        <p><strong>Grade received:</strong> {{ round(($score / $total) * 100) }}%</p>
        <p><strong>Latest submission:</strong> Grade {{ round(($score / $total) * 100) }}%</p>
        <p><strong>To pass:</strong> 80% or higher</p>
    </div>
    <div class="mt-4">
        <a href="{{ route('quis') }}" class="btn-primary">Try again</a>
    </div>
</div>

    @foreach ($results as $index => $item)
    <div class="question-block">
        <div class="question-title">
            <span>{{ $index + 1 }}. {{ $item['question'] }}</span>
            <span class="text-sm text-gray-500">
                {{ $item['selected'] === $item['correct'] ? '1 / 1 point' : '0 / 1 point' }}
            </span>
        </div>

        @foreach ($item['options'] as $option)
            @php
                $isSelected = $item['selected'] === $option;
                $isCorrect = $item['correct'] === $option;
                $class = $isCorrect ? 'correct' : ($isSelected ? 'incorrect' : '');
            @endphp

            <div class="option-label {{ $class }}">
                <input type="radio" disabled {{ $isSelected ? 'checked' : '' }}>
                {{ $option }}

                @if ($isCorrect && $isSelected)
                    <span class="text-green-600 font-medium ml-2">Correct</span>
                @elseif ($isSelected && !$isCorrect)
                    <span class="text-red-600 font-medium ml-2">Incorrect</span>
                @elseif ($isCorrect && !$isSelected)
                    <span class="text-green-600 font-medium ml-2">Correct Answer</span>
                @endif
            </div>
        @endforeach
    </div>
    @endforeach
</div>
@endsection
