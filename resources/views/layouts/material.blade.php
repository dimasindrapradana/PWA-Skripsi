@extends('layouts.app')

@section('title', $material->title)

@section('content')
<div class="relative min-h-screen bg-gray-50">
@include('components.material-navbar')

    <div class="max-w-3xl mx-auto p-4 sm:p-8 pb-[92px] sm:pb-8"> 
        <main>
            <h2 class="text-2xl font-bold text-slate-800 mb-4">{{ $material->title }}</h2>
            {{-- VIDEO --}}
            @if ($material->videos->where('video_url', '!=', '')->count())
            <div class="mb-6 space-y-4">
                @foreach ($material->videos as $video)
                    @if ($video->video_url)
                        @php
                            $embedUrl = null;

                            // YouTube - watch?v=... or shorts/...
                            if (Str::contains($video->video_url, 'youtube.com/watch')) {
                                $embedUrl = Str::replace('watch?v=', 'embed/', $video->video_url);
                            } elseif (Str::contains($video->video_url, 'youtube.com/shorts')) {
                                $videoId = Str::afterLast($video->video_url, '/shorts/');
                                $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                            }

                            // TikTok
                            if (Str::contains($video->video_url, 'tiktok.com')) {
                                // Gunakan tiktok embed format
                                $embedUrl = 'https://www.tiktok.com/embed/' . Str::after($video->video_url, '/video/');
                            }
                        @endphp

                        @if ($embedUrl)
                            <div>
                                <div class="aspect-w-16 aspect-h-9 mb-2">
                                    <iframe 
                                        class="w-full h-64 rounded-xl"
                                        src="{{ $embedUrl }}"
                                        frameborder="0"
                                        allowfullscreen></iframe>
                                </div>
                                <p class="text-sm text-slate-600">Video: {{ $video->description }}</p>
                            </div>
                        @endif
                    @endif
                @endforeach
            </div>
            @endif

            {{-- IMAGES --}}
           <div x-data="{ open: false, imageUrl: '', imageDesc: '' }">
                <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-6 place-items-center">
                    @foreach ($material->images as $image)
                        <div class="bg-white p-3 rounded-2xl shadow-lg flex flex-col items-center w-full max-w-[330px] transition hover:scale-105">
                            <img @click="open = true; imageUrl = '{{ asset('storage/' . $image->image_url) }}'; imageDesc = '{{ $image->description }}'"
                                src="{{ asset('storage/' . $image->image_url) }}"
                                alt="{{ $image->description }}"
                                class="rounded-xl mb-2 w-full max-w-xs object-contain max-h-64 mx-auto cursor-zoom-in" />
                            <p class="text-sm text-slate-600">Gambar: {{ $image->description }}</p>
                        </div>
                    @endforeach
                </div>

                <!-- Modal Zoom -->
                <div x-show="open" 
                    x-transition 
                    x-cloak
                    class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50">
                    <div @click.away="open = false" class="relative max-w-3xl w-full px-4">
                        <button @click="open = false"
                                class="absolute -top-4 -right-4 text-black text-2xl font-bold    rounded-full w-8 h-8 flex items-center justify-center shadow-lg">
                            &times;
                        </button>
                        <img :src="imageUrl" :alt="imageDesc" class="rounded-xl max-h-[90vh] mx-auto object-contain w-full">
                        <p class="mt-2 text-white text-center text-sm" x-text="imageDesc"></p>
                    </div>
                </div>
            </div>


            {{-- KONTEN HTML --}}
            <div class="prose max-w-none mb-8 text-justify">
                {!! $material->content !!}
            </div>
            
            {{-- SUBMISSION --}}
            @php
                $submission = $material->submissions
                    ->where('user_id', auth()->id())
                    ->sortByDesc('created_at')
                    ->first();
                $showForm = request('reatemp') == '1';
            @endphp

            @if ($material->is_submission_point && !$submission)
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
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                            Kumpulkan
                        </button>
                    </form>
                </div>
            @elseif ($material->is_submission_point)
                @if(!$showForm)
                <div class="mt-6 p-4 bg-green-50 border border-green-300 rounded">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <p class="text-green-700 font-semibold mb-1">✅ Tugas sudah dikumpulkan.</p>
                            <div class="text-xs text-gray-500 mb-1">
                                Dikirim pada: {{ $submission->created_at->format('d M Y H:i') }}
                            </div>
                        </div>
                        <form method="GET" class="inline-block">
                            <button type="submit" name="reatemp" value="1"
                                class="text-sm px-3 py-1 rounded bg-yellow-200 text-yellow-900 hover:bg-yellow-300 font-semibold transition ml-3">
                                Kirim Ulang Tugas
                            </button>
                        </form>
                    </div>
                    @if($submission)
                        <div class="mt-2">
                            <div class="text-sm text-slate-800 font-semibold mb-1">Link Tugas:</div>
                            <a href="{{ $submission->link }}" class="text-indigo-700 hover:underline break-all" target="_blank">
                                {{ $submission->link }}
                            </a>
                        </div>
                        @if($submission->description)
                        <div class="mt-2">
                            <div class="text-sm text-slate-800 font-semibold mb-1">Deskripsi:</div>
                            <div class="text-slate-700">{{ $submission->description }}</div>
                        </div>
                        @endif
                    @endif
                </div>
                @else
                {{-- FORM RESUBMIT/REATEMP --}}
                <div class="mt-8 p-4 border rounded bg-gray-100">
                    <h2 class="text-lg font-semibold mb-2">Kirim Ulang Tugas</h2>
                    <form action="{{ route('submission.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="material_id" value="{{ $material->id }}">
                        <label for="link" class="block font-medium mb-1">Link Google Drive</label>
                        <input type="url" name="link" id="link"
                            value="{{ old('link', $submission->link ?? '') }}"
                            class="w-full p-2 border rounded mb-3"
                            placeholder="https://drive.google.com/..." required>
                        <label for="description" class="block font-medium mb-1">Deskripsi (Opsional)</label>
                        <textarea name="description" id="description"
                            class="w-full p-2 border rounded mb-3" rows="2"
                            placeholder="Catatan atau deskripsi singkat">{{ old('description', $submission->description ?? '') }}</textarea>
                        <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                            Kirim Ulang
                        </button>
                    </form>
                </div>
                @endif
            @endif
        </main>     
    
        {{-- NAVBAR  --}}
      <div class="w-full flex flex-row gap-2 justify-between mt-8">
    {{-- Tombol Sebelumnya --}}
    @if ($previous)
        <a href="{{ route('materi.show', $previous->slug) }}"
           class="px-3 py-2 rounded-lg bg-slate-200 text-slate-700 hover:bg-slate-300 font-medium text-sm transition text-center whitespace-nowrap flex-1 sm:flex-none">
            &larr; Materi Sebelumnya
        </a>
    @else
        <span class="px-3 py-2 rounded-lg bg-slate-100 text-slate-400 cursor-not-allowed text-center text-sm flex-1 sm:flex-none whitespace-nowrap">
            &larr; Materi Sebelumnya
        </span>
    @endif

    {{-- Tombol Selanjutnya --}}
    @if ($material->is_submission_point && !$next)
        <a href="{{ route('materials.index') }}"
           class="px-3 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 font-medium text-sm transition text-center whitespace-nowrap flex-1 sm:flex-none">
            Kembali ke Daftar Materi
        </a>
    @elseif ($next)
        <a href="{{ route('materi.show', $next->slug) }}"
           class="px-3 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 font-medium text-sm transition text-center whitespace-nowrap flex-1 sm:flex-none">
            Materi Selanjutnya &rarr;
        </a>
    @else
        <span class="px-3 py-2 rounded-lg bg-slate-100 text-slate-400 cursor-not-allowed text-center text-sm flex-1 sm:flex-none whitespace-nowrap">
            Materi Selanjutnya &rarr;
        </span>
    @endif
</div>


{{-- SIDEBAR POPUP MATERI --}}
<aside class="fixed inset-0 z-40 transition-all duration-300 ease-in-out" id="materialSidebar" aria-modal="true" role="dialog" style="transform: translateX(100%)">
    <div id="sidebarOverlay" class="absolute inset-0 bg-slate-900/40 transition-opacity opacity-0 pointer-events-none"></div>
    <div class="absolute right-0 top-0 h-full w-80 max-w-full bg-white shadow-2xl flex flex-col transition-transform"
        style="transform: translateX(100%);" id="sidebarContent">
        <div class="p-6 flex flex-col h-full" x-data="{ openCategory: {{ $material->category->id }} }">
            <div class="flex items-center justify-between mb-4">
                <span class="font-semibold text-lg text-indigo-700">Navigasi Materi</span>
                <button type="button" id="sidebarClose" class="text-slate-400 hover:text-red-400 transition">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto max-h-[calc(100vh-80px)] pr-2">
                @foreach ($categories as $category)
                    <div class="mb-4">
                        <button @click="openCategory = openCategory === {{ $category->id }} ? null : {{ $category->id }}"
                                class="w-full flex items-center justify-between text-indigo-600 font-semibold hover:underline mb-1 transition">
                            <span>{{ $category->name }}</span>
                            <svg :class="openCategory === {{ $category->id }} ? 'rotate-180' : 'rotate-0'"
                                 class="w-4 h-4 transform transition-transform duration-200"
                                 fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="openCategory === {{ $category->id }}" x-transition>
                            <div class="grid gap-2 pl-2 border-l border-indigo-200 mt-2">
                                {{-- Link Pengantar Kategori --}}
                                <a href="{{ route('kategori.show', $category->slug) }}"
                                   class="block p-2 rounded-xl bg-yellow-100 text-yellow-800 border border-yellow-300 text-sm font-medium hover:bg-yellow-200 transition">
                                    Pengantar {{ $category->name }}
                                </a>
                               

                                {{-- Daftar Materi --}}
                                @foreach ($category->materials as $item)
                                    <a href="{{ route('materi.show', $item->slug) }}"
                                       class="block p-2 rounded-xl border text-sm transition
                                       {{ $item->id === $material->id ? 'bg-indigo-100 border-indigo-500 text-indigo-700 shadow-md' : 'bg-slate-50 hover:bg-indigo-100 border-slate-200 text-slate-800' }}">
                                        {{ $item->title }}
                                    </a>
                                @endforeach
                                {{-- Daftar quis --}}
                                 
                                @if ($category->tests->count())
                                    <div class="mt-3 border-t pt-2 border-slate-200">
                                        <span class="text-[11px] uppercase text-slate-400 font-semibold">Kuis</span>
                                        <div class="grid gap-2 mt-1">
                                            @foreach ($category->tests as $test)
                                                @if(in_array($test->material_id, $readMaterialIds))
                                                    <a href="{{ route('quiz.show', $test->slug) }}"
                                                    class="block p-2 rounded-xl bg-white border text-sm text-blue-700 hover:bg-blue-50 border-blue-200 transition">
                                                    📝 {{ $test->title }}
                                                    </a>
                                                @else
                                                    <button onclick="alert('Silakan baca materi terkait terlebih dahulu untuk membuka kuis ini.')"
                                                        class="block w-full text-left p-2 rounded-xl bg-slate-100 border text-sm text-slate-400 border-slate-300 cursor-not-allowed">
                                                        📝 {{ $test->title }}
                                                    </button>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</aside>



    {{-- SCRIPT TOGGLE SIDEBAR --}}
    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        const materialSidebar = document.getElementById('materialSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const sidebarContent = document.getElementById('sidebarContent');
        const sidebarClose = document.getElementById('sidebarClose');

        sidebarToggle.onclick = function() {
            materialSidebar.style.transform = 'translateX(0)';
            sidebarContent.style.transform = 'translateX(0)';
            sidebarOverlay.classList.remove('opacity-0', 'pointer-events-none');
            sidebarOverlay.classList.add('opacity-100');
            setTimeout(() => {
                sidebarOverlay.classList.remove('pointer-events-none');
            }, 50);
        };
        sidebarClose.onclick = function() {
            materialSidebar.style.transform = 'translateX(100%)';
            sidebarContent.style.transform = 'translateX(100%)';
            sidebarOverlay.classList.add('opacity-0', 'pointer-events-none');
        };
        sidebarOverlay.onclick = function() {
            materialSidebar.style.transform = 'translateX(100%)';
            sidebarContent.style.transform = 'translateX(100%)';
            sidebarOverlay.classList.add('opacity-0', 'pointer-events-none');
        };
    </script>

</div>
@endsection
