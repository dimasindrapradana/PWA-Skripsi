@extends('layouts.app')

@section('content')
@include('components.quis-navbar')

<div class="quiz-container">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-bold">Module 1 Challenge</h1>
        <div id="timer" class="text-md font-semibold text-red-600">Time left: 10:00</div>
    </div>

    <form method="POST" action="{{ route('quis.submit') }}">
        @csrf

        {{-- Soal 1 --}}
        <div class="question-block">
            <div class="question-title">
                <span>1. Apa ibukota Indonesia?</span>
                <span class="text-sm text-gray-500">1 point</span>
            </div>
            <label class="option-label">
                <input type="radio" name="answer[1]" value="A"> Surabaya
            </label>
            <label class="option-label">
                <input type="radio" name="answer[1]" value="B"> Jakarta
            </label>
            <label class="option-label">
                <input type="radio" name="answer[1]" value="C"> Bandung
            </label>
            <label class="option-label">
                <input type="radio" name="answer[1]" value="D"> Medan
            </label>
        </div>

        {{-- Soal 2 --}}
        <div class="question-block">
            <div class="question-title">
                <span>2. 2 + 2 = ?</span>
                <span class="text-sm text-gray-500">1 point</span>
            </div>
            <label class="option-label">
                <input type="radio" name="answer[2]" value="A"> 3
            </label>
            <label class="option-label">
                <input type="radio" name="answer[2]" value="B"> 4
            </label>
            <label class="option-label">
                <input type="radio" name="answer[2]" value="C"> 5
            </label>
            <label class="option-label">
                <input type="radio" name="answer[2]" value="D"> 6
            </label>
        </div>

        <div class="quiz-footer">
            <button type="submit" class="btn-primary">Submit</button>
            <button type="button" class="btn-secondary">Save draft</button>
        </div>
    </form>
</div>

<script>
    let time = 10 * 60;
    const timerEl = document.getElementById('timer');
    setInterval(() => {
        const minutes = Math.floor(time / 60);
        const seconds = time % 60;
        timerEl.textContent = `Time left: ${minutes}:${seconds.toString().padStart(2, '0')}`;
        if (time > 0) time--;
    }, 1000);
</script>
@endsection
