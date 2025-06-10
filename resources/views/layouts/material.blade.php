@extends('layouts.app')

@section('title', $material->title)

@section('content')
<div class="relative min-h-screen bg-gray-50">
@include('components.material-navbar')

    <div class="max-w-3xl mx-auto p-4 sm:p-8">
        <main>
            <h2 class="text-2xl font-bold text-slate-800 mb-4">{{ $material->title }}</h2>
           
            @if ($material->videos->where('video_url', '!=', '')->count())
    <div class="mb-6 space-y-4">
        @foreach ($material->videos as $video)
            @if ($video->video_url)
                        <div>
                            <div class="aspect-w-16 aspect-h-9 mb-2">
                                <iframe 
                                    class="w-full h-64 rounded" 
                                    src="{{ Str::replace('watch?v=', 'embed/', $video->video_url) }}" 
                                    frameborder="0" allowfullscreen></iframe>
                            </div>
                            <p class="text-sm text-slate-600">Video: {{ $video->description }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif

            {{-- IMAGE SECTION --}}
           @if ($material->images->count())
                <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4 justify-items-center">
                    @foreach ($material->images as $image)
                        <div class="bg-white p-2 rounded shadow flex flex-col items-center max-w-xs w-full">
                            <img src="{{ asset('storage/' . $image->image_url) }}"
                                alt="{{ $image->description }}"
                                class="rounded mb-2 w-full max-w-xs object-contain" />
                            <p class="text-center text-sm text-gray-700">{{ $image->description }}</p>
                        </div>
                    @endforeach
                </div>
            @endif


            {{-- DESKRIPSI / MATERI --}}
            <div class="prose max-w-none mb-8">
                {!! nl2br(e($material->content)) !!}
            </div>

            {{-- SUBMISSION --}}
            @if ($material->is_submission_point && !$material->submissions->where('user_id', auth()->id())->first())
                <div id="submission" class="mt-8 p-4 border rounded bg-gray-100">
                    <h2 class="text-lg font-semibold mb-2">Kumpulkan Tugas</h2>
                    <form action="{{ route('submission.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="material_id" value="{{ $material->id }}">
                        <label for="link" class="block font-medium mb-1">Link Google Drive</label>
                        <input type="url" name="link" id="link"
                               class="w-full p-2 border rounded mb-3"
                               placeholder="https://drive.google.com/..." required>
                        <label for="description" class="block font-medium mb-1">Deskripsi (Opsional)</label>
                        <textarea name="description" id="description"
                                  class="w-full p-2 border rounded mb-3" rows="2"
                                  placeholder="Catatan atau deskripsi singkat"></textarea>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Kumpulkan
                        </button>
                    </form>
                </div>
            @elseif ($material->is_submission_point)
                <div class="mt-6 p-4 bg-green-100 border border-green-300 rounded">
                    <p class="text-green-700 font-semibold">✅ Tugas sudah dikumpulkan.</p>
                </div>
            @endif

            {{-- QUIZ --}}
            @if ($material->tests->isNotEmpty())
                <div id="quiz" class="mt-6">
                    <a href="{{ route('quiz.show', $material->slug) }}"
                       class="inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        Kerjakan Kuis
                    </a>
                </div>
            @endif

            {{-- NAV BOTTOM --}}
            <div class="flex items-center justify-between mt-12 gap-4">
                @if ($previous)
                    <a href="{{ route('materi.show', $previous->slug) }}"
                       class="px-4 py-2 rounded bg-slate-200 text-slate-700 hover:bg-slate-300 transition">
                        &larr; Materi Sebelumnya
                    </a>
                @else
                    <span class="px-4 py-2 rounded bg-slate-100 text-slate-400 cursor-not-allowed">&larr; Materi Sebelumnya</span>
                @endif

                @if ($next)
                    <a href="{{ route('materi.show', $next->slug) }}"
                       class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 transition">
                        Materi Selanjutnya &rarr;
                    </a>
                @else
                    <span class="px-4 py-2 rounded bg-slate-100 text-slate-400 cursor-not-allowed">Materi Selanjutnya &rarr;</span>
                @endif
            </div>
        </main>
    </div>

    {{-- SIDEBAR POPUP MATERI --}}
    <aside class="fixed inset-0 z-40 hidden" id="materialSidebar" aria-modal="true" role="dialog">
    <div id="sidebarOverlay" class="absolute inset-0 bg-slate-900/50 transition-opacity"></div>
        <div class="absolute right-0 top-0 h-full w-80 max-w-full bg-white shadow-2xl p-6 flex flex-col overflow-y-auto transition-transform translate-x-0">
            <div class="flex items-center justify-between mb-4">
            <span class="font-semibold text-lg text-slate-800">{{ $material->category->name }}</span>
            <button type="button" id="sidebarClose" class="text-slate-400 hover:text-red-400 transition">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            </div>
            @foreach ($materials->groupBy('category_id') as $group)
                <div class="mb-6">
                    <div class="text-xs uppercase text-slate-500 font-semibold mb-2">Materi</div>
                    <ul class="space-y-1">
                        @foreach ($group as $item)
                            <li>
                                <a href="{{ route('materi.show', $item->slug) }}"
                                   class="flex items-center px-3 py-2 rounded transition font-medium
                                    {{ $item->id === $material->id ? 'bg-blue-50 text-blue-700' : 'hover:bg-slate-100 text-slate-700' }}">
                                    <span class="mr-2">
                                        {{ $item->id === $material->id ? '◉' : '○' }}
                                    </span>
                                    {{ $item->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach

            <div class="mt-6">
                <div class="text-xs uppercase text-slate-500 font-semibold mb-2">Navigasi</div>
                <ul class="space-y-1">
                    <li>
                        <a href="#submission" class="flex items-center px-3 py-2 rounded hover:bg-slate-100 text-slate-700">
                            <span class="mr-2">📥</span> Submission
                        </a>
                    </li>
                    <li>
                        <a href="#quiz" class="flex items-center px-3 py-2 rounded hover:bg-slate-100 text-slate-700">
                            <span class="mr-2">📝</span> Kuis
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </aside>

    {{-- SCRIPT TOGGLE SIDEBAR --}}
    <script>
        document.getElementById('sidebarToggle').onclick = function() {
            document.getElementById('materialSidebar').classList.remove('hidden');
        };
        document.getElementById('sidebarClose').onclick = function() {
            document.getElementById('materialSidebar').classList.add('hidden');
        };
        document.getElementById('sidebarOverlay').onclick = function() {
            document.getElementById('materialSidebar').classList.add('hidden');
        };
    </script>

</div>
@endsection
