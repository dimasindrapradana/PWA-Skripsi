    @extends('layouts.app')

    @section('title', $test->title)

    @section('content')
    <div class="flex">
        @include('components.quis-navbar')

        <h2 class="text-2xl font-bold mb-4 mt-4">{{ $test->title }}</h2>

        <form action="{{ route('quiz.submit', $test->slug) }}" method="POST" id="quizForm">
            @csrf

            @foreach($test->questions as $index => $question)
                <div class="mb-6" id="question-{{ $index + 1 }}">
                    <p class="font-semibold">{{ $index+1 }}. {{ $question->question_text }}</p>

                    @if ($question->image)
                        <img src="{{ asset('storage/' . $question->image) }}" class="my-2 w-1/3">
                    @endif

                    @foreach ($question->options as $option)
                        <div class="flex items-center space-x-2">
                            <input type="radio"
                                name="answers[{{ $question->id }}]"
                                value="{{ $option->id }}"
                                {{ old("answers.{$question->id}") == $option->id ? 'checked' : '' }}
                                required>
                            <label>{{ $option->option_text }}</label>
                        </div>
                    @endforeach
                </div>
            @endforeach
            <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">Kumpulkan</button>
        </form>
    </div>

    <script>
        const timeLimit = {{ $test->time_limit ?? 10 }};
        let duration = timeLimit * 60;
        const countdownEl = document.getElementById('countdown');
        const quizForm = document.getElementById('quizForm');

        function updateTimer() {
            const minutes = Math.floor(duration / 60);
            const seconds = duration % 60;
            countdownEl.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

            if (duration <= 0) {
                clearInterval(timer);
                alert("Waktu habis! Kuis akan dikumpulkan otomatis.");
                quizForm.submit();
            }

            duration--;
        }

        const timer = setInterval(updateTimer, 1000);
        updateTimer();
         </script>

        <script>
        const inputs = document.querySelectorAll("input[type='radio']");

        // Saat halaman dimuat, restore jawaban yang disimpan
        inputs.forEach(input => {
            const savedValue = localStorage.getItem(input.name);
            if (savedValue && input.value === savedValue) {
                input.checked = true;
            }

            input.addEventListener('change', () => {
                if (input.checked) {
                    localStorage.setItem(input.name, input.value);
                }
            });
        });

        // Hapus localStorage saat submit
        quizForm.addEventListener('submit', () => {
            inputs.forEach(input => localStorage.removeItem(input.name));
        });
        </script>
    @endsection