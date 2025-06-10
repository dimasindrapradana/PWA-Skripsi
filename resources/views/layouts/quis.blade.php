@extends('layouts.app')

@section('title', $test->title)

@section('content')
<div class="min-h-screen bg-gray-50">

    {{-- NAVBAR QUIZ --}}
    <nav class="sticky top-0 z-30 bg-white/90 border-b border-gray-200 shadow-sm flex items-center px-4 py-2">
        <a href="{{ route('materi.show', $material->slug) }}"
        class="text-gray-500 hover:text-blue-600 px-3 py-1 rounded transition text-sm mr-3 flex items-center gap-1">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Materi
        </a>
        <div class="flex-1 flex items-center gap-3">
            <span class="text-lg font-bold text-blue-600">{{ $test->title }}</span>
            <div id="countdown" class="ml-6 text-base font-mono text-white bg-blue-600 px-3 py-1.5 rounded shadow"></div>
        </div>
    </nav>


    {{-- PROGRESS BAR + NAVIGASI SOAL MOBILE --}}
    <div class="sticky top-[56px] z-20 bg-white border-b border-gray-200 px-0 sm:px-4">
        <div class="max-w-2xl mx-auto flex flex-col">
            {{-- PROGRESS BAR --}}
            <div class="h-3 w-full rounded bg-slate-200 my-2 overflow-hidden">
                <div id="progressBar" class="h-full bg-yellow-500 transition-all duration-300" style="width:0%"></div>
            </div>
            <div class="text-xs text-slate-600 text-right pb-1" id="progressLabel"></div>
            {{-- NAVIGASI SOAL MOBILE (horizontal, hanya di mobile) --}}
            <div class="flex sm:hidden gap-1 overflow-x-auto py-2 mb-1">
                @foreach($test->questions as $index => $question)
                    <button type="button"
                        onclick="document.getElementById('question-{{ $index + 1 }}').scrollIntoView({ behavior: 'smooth', block: 'center' })"
                        class="w-8 h-8 rounded-full border-2 border-blue-200 text-blue-700 font-bold
                            focus:outline-none focus:ring-2 focus:ring-blue-300
                            transition shadow
                            bg-white hover:bg-blue-100"
                        id="nav-btn-mobile-{{ $index + 1 }}">
                        {{ $index + 1 }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto flex relative">

        {{-- BAGIAN SOAL --}}
        <div class="flex-1 p-4 sm:p-8">
            <form action="{{ route('quiz.submit', $test->slug) }}" method="POST" id="quizForm" autocomplete="off">
                @csrf

                @foreach($test->questions as $index => $question)
                    <div class="mb-8 p-5 bg-white rounded-xl shadow" id="question-{{ $index + 1 }}">
                        <p class="font-semibold mb-2 text-gray-800 text-lg">{{ $index+1 }}. {{ $question->question_text }}</p>
                        
                        @if ($question->image)
                            <div class="flex justify-center">
                                <img src="{{ asset('storage/' . $question->image) }}" class="my-3 max-w-xs rounded shadow">
                            </div>
                        @endif

                        <div class="grid gap-3 mt-3">
                            @foreach ($question->options as $option)
                                <label class="flex items-center cursor-pointer gap-3 p-2 rounded border border-slate-200 hover:bg-blue-50 transition answer-label"
                                    for="option-{{ $option->id }}">
                                    <input type="radio"
                                        id="option-{{ $option->id }}"
                                        name="answers[{{ $question->id }}]"
                                        value="{{ $option->id }}"
                                        class="accent-blue-600 h-4 w-4"
                                        {{ old("answers.{$question->id}") == $option->id ? 'checked' : '' }}
                                        required>
                                    <span>{{ $option->option_text }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <button type="submit" class="w-full bg-yellow-500 text-white font-bold py-3 rounded-lg shadow hover:bg-yellow-600 transition text-lg">
                    Kumpulkan Jawaban
                </button>
            </form>
        </div>

        {{-- NAVIGASI SOAL DI KANAN (desktop only) --}}
        {{-- <div class="hidden sm:flex flex-col gap-2 sticky top-[110px] self-start ml-4 pr-2 items-end">
            @foreach($test->questions as $index => $question)
                <button type="button"
                    onclick="document.getElementById('question-{{ $index + 1 }}').scrollIntoView({ behavior: 'smooth', block: 'center' })"
                    class="w-10 h-10 rounded-full border-2 border-blue-200 text-blue-700 font-bold
                        focus:outline-none focus:ring-2 focus:ring-blue-300
                        transition shadow
                        bg-white hover:bg-blue-100"
                    id="nav-btn-{{ $index + 1 }}">
                    {{ $index + 1 }}
                </button>
            @endforeach
        </div> --}}
    </div>

    {{-- JS INTERAKTIF --}}
    <script>
        // Timer Countdown
        const timeLimit = {{ $test->time_limit ?? 10 }};
        let duration = timeLimit * 60;
        const countdownEl = document.getElementById('countdown');
        const quizForm = document.getElementById('quizForm');
        let timer;

        function updateTimer() {
            const minutes = Math.floor(duration / 60);
            const seconds = duration % 60;
            countdownEl.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            if (duration <= 60) {
                countdownEl.classList.add('bg-red-600');
                countdownEl.classList.remove('bg-blue-600');
            }
            if (duration <= 0) {
                clearInterval(timer);
                alert("Waktu habis! Kuis akan dikumpulkan otomatis.");
                quizForm.submit();
            }
            duration--;
        }
        timer = setInterval(updateTimer, 1000);
        updateTimer();

        // Jawaban: Auto Save (LocalStorage)
        const inputs = document.querySelectorAll("input[type='radio']");
        const totalQuestions = {{ count($test->questions) }};
        let answeredCount = 0;

        // Progress bar update
        function updateProgressBar() {
            let answered = 0;
            document.querySelectorAll("input[type='radio']:checked").forEach(() => answered++);
            answeredCount = answered;
            let percent = totalQuestions > 0 ? (answered / totalQuestions * 100) : 0;
            document.getElementById('progressBar').style.width = percent + '%';
            document.getElementById('progressLabel').textContent = `Terjawab: ${answered} / ${totalQuestions}`;
        }

        // Auto-save & highlight nav
        inputs.forEach(input => {
            const savedValue = localStorage.getItem(input.name);
            if (savedValue && input.value === savedValue) {
                input.checked = true;
            }
            input.addEventListener('change', () => {
                if (input.checked) {
                    localStorage.setItem(input.name, input.value);
                    highlightNavButton(input.name);
                    highlightNavButtonMobile(input.name);
                    updateProgressBar();
                }
            });
        });
        quizForm.addEventListener('submit', () => {
            inputs.forEach(input => localStorage.removeItem(input.name));
        });

        // Highlight tombol nav jika soal sudah dijawab (desktop)
        function highlightNavButton(name) {
            let id = name.match(/\d+/);
            if (id) {
                let btn = document.getElementById('nav-btn-' + id[0]);
                if (btn) {
                    btn.classList.add('bg-blue-500', 'text-white', 'border-blue-600');
                    btn.classList.remove('bg-white', 'text-blue-700', 'border-blue-200');
                }
            }
        }
        // Highlight tombol nav jika soal sudah dijawab (mobile)
        function highlightNavButtonMobile(name) {
            let id = name.match(/\d+/);
            if (id) {
                let btn = document.getElementById('nav-btn-mobile-' + id[0]);
                if (btn) {
                    btn.classList.add('bg-blue-500', 'text-white', 'border-blue-600');
                    btn.classList.remove('bg-white', 'text-blue-700', 'border-blue-200');
                }
            }
        }
        // On page load: highlight nav button for answered
        inputs.forEach(input => {
            if (input.checked) {
                highlightNavButton(input.name);
                highlightNavButtonMobile(input.name);
            }
        });

        // Update progress bar on page load
        updateProgressBar();
        // Konfirmasi submit quiz
        quizForm.addEventListener('submit', function(e) {
            if (!confirm('Kumpulkan jawaban sekarang? Pastikan semua soal sudah dijawab.')) {
                e.preventDefault();
            }
        });
    </script>
</div>
@endsection
