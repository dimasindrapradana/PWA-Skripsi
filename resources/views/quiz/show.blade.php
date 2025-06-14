@extends('layouts.app')
@section('title', $test->title)

@section('content')

<nav class="top-0 z-50 w-full bg-white shadow-lg py-3 px-4 sm:px-8 flex items-center justify-between mb-6 relative">
   
    <a href="{{ route('quiz.index') }}"
        class="flex items-center h-9 px-2 sm:px-4 rounded-md border border-indigo-200 bg-white/80 hover:bg-indigo-50 text-indigo-700 font-medium text-sm sm:text-base transition focus:outline-none focus:ring-2 focus:ring-indigo-200"
        aria-label="Kembali ke Daftar Kuis">
        <svg class="w-5 h-5 mr-1 sm:w-6 sm:h-6 sm:mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        <span class="font-medium">Kembali</span>
    </a>
    
    <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
        <span class="text-base sm:text-lg font-bold text-indigo-700 tracking-tight text-center block">Mode Kuis</span>
    </div>
     
    <div class="w-9 h-9"></div>
    @if($test->time_limit)
        <div class="absolute left-0 bottom-0 w-full h-[3px] bg-yellow-200">
            <div id="timer-progress" class="h-full bg-yellow-400 transition-all duration-200 ease-linear" style="width:0%"></div>
        </div>
    @endif
</nav>

<div class="max-w-2xl mx-auto py-8 px-2 sm:px-0">
    <h1 class="text-2xl font-bold mb-4 text-indigo-900">{{ $test->title }}</h1>
    <p class="mb-3 text-indigo-700 text-sm">Materi: {{ $material->title ?? '-' }}</p>
    @if($test->time_limit)
        <div class="text-right text-base font-bold text-yellow-600 mb-5 mt-1">
            Sisa waktu: <span id="time-remaining"></span>
        </div>
    @endif

    <form id="quiz-form" action="{{ route('quiz.submit', $test->slug) }}" method="POST" autocomplete="off">
        @csrf
        <div class="flex flex-col gap-7">
        @foreach($questions as $index => $question)
            <input type="hidden" name="question_ids[]" value="{{ $question->id }}">
            <div class="rounded-2xl bg-white/95 shadow-lg p-5 sm:p-6 border border-slate-100 transition hover:shadow-xl relative">
                <div class="flex items-center gap-3 mb-2">
                    <span class="rounded-xl bg-indigo-600 text-white font-bold w-8 h-8 text-base flex items-center justify-center shadow-md border-4 border-indigo-100">{{ $index + 1 }}</span>
                    <span class="text-base font-semibold text-slate-900 leading-snug flex-1">{{ $question->question_text }}</span>
                </div>
                @if($question->images && count($question->images))
                <div class="flex flex-wrap gap-3 my-3 justify-center">
                    @foreach($question->images as $img)
                        <figure class="flex flex-col items-center">
                            <img src="{{ asset('storage/'.$img->image_url) }}" class="rounded shadow max-h-32 max-w-[140px] object-contain mb-1 border border-indigo-100">
                        </figure>
                    @endforeach
                </div>
                @endif

                {{-- PILIHAN JAWABAN --}}
                <div class="flex flex-col gap-2 mt-2">
                @foreach ($question->options as $option)
                    <label class="w-full block cursor-pointer group">
                        <input 
                            type="radio"
                            name="answers[{{ $question->id }}]"
                            value="{{ $option->id }}"
                            class="hidden pilihan-jawaban"
                            onchange="updateAnswerProgress()"
                            required>
                        <div class="w-full rounded-lg py-3 px-4 border border-slate-200 bg-slate-50 group-hover:bg-yellow-50 transition-all
                            font-medium text-slate-900 flex items-center gap-2 shadow-sm
                            peer-checked:bg-yellow-400 peer-checked:border-yellow-400 peer-checked:text-yellow-900
                            pilihan-block"
                            style="transition:.16s"
                        >
                            <span class="w-4 h-4 rounded-full border-2 border-slate-400 mr-2 flex-shrink-0 bg-white group-checked:border-yellow-400"></span>
                            <span class="flex-1">{{ $option->option_text }}</span>
                        </div>
                    </label>
                @endforeach
                </div>
            </div>
        @endforeach
        </div>

        {{-- Progress Bar Jawaban --}}
        <div class="mb-6 mt-10 sm:mt-12">
            <div class="flex justify-between text-xs mb-2">
                <span id="progress-label" class="text-yellow-700">0/{{ count($questions) }} Terjawab</span>
                <span id="progress-percent" class="text-yellow-700">0%</span>
            </div>
            <div class="w-full h-2 bg-yellow-100 rounded-full overflow-hidden min-w-[80px]">
                <div id="answer-progress-bar" class="h-full bg-yellow-400 transition-all duration-300 ease-linear" style="width:0%"></div>
            </div>
        </div>

        <div class="flex justify-center mt-6 sm:mt-8">
            <button type="submit"
                class="bg-yellow-400 hover:bg-yellow-500 text-indigo-900 px-4 py-2 rounded-lg font-bold w-full sm:w-auto shadow transition text-base">
                Kumpulkan Jawaban
            </button>
        </div>
    </form>
</div>


{{-- TIMER JS & PROGRESS BAR --}}
@if($test->time_limit)
<script>
    let time = {{ $test->time_limit * 60 }};
    const totalTime = time;
    const display = document.getElementById('time-remaining');
    const bar = document.getElementById('timer-progress');
    const form = document.getElementById('quiz-form');
    let timerInterval;

    function updateTimer() {
        const minutes = Math.floor(time / 60);
        const seconds = time % 60;
        display.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
        const percent = ((totalTime - time) / totalTime) * 100;
        bar.style.width = percent + "%";
        if (time <= 0) {
            clearInterval(timerInterval);
            alert('Waktu habis! Jawabanmu akan dikumpulkan otomatis.');
            form.submit();
        }
        time--;
    }
    updateTimer();
    timerInterval = setInterval(updateTimer, 1000);
</script>
@endif

<script>
// JS progress jawaban
function updateAnswerProgress() {
    const radios = document.querySelectorAll('.pilihan-jawaban');
    const soalUnik = new Set();
    radios.forEach(q => {
        if(q.checked) soalUnik.add(q.name);
        // highlight pilihan yang dipilih
        const block = q.parentElement.querySelector('.pilihan-block');
        if(q.checked){
            block.classList.add('bg-yellow-400', 'border-yellow-400', 'text-yellow-900');
            block.classList.remove('bg-slate-50');
        }else{
            block.classList.remove('bg-yellow-400', 'border-yellow-400', 'text-yellow-900');
            block.classList.add('bg-slate-50');
        }
    });
    const jumlahTerjawab = soalUnik.size;
    const total = {{ count($questions) }};
    const percent = Math.round((jumlahTerjawab/total)*100);
    document.getElementById('progress-label').textContent = `${jumlahTerjawab}/${total} Terjawab`;
    document.getElementById('progress-percent').textContent = percent + '%';
    document.getElementById('answer-progress-bar').style.width = percent + '%';
}
// panggil sekali saat load
updateAnswerProgress();
</script>
@endsection
