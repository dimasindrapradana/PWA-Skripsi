@extends('layouts.app')

@section('title', $material->title)

@section('content')
<div class="material-page">
    @include('components.material-navbar')

    <div class="material-body">
        <main class="material-main">
            <h1 class="material-title">{{ $material->title }}</h1>
            {{-- VIDEO SECTION --}}
            @if ($material->videos->count())
                <div class="material-videos mt-6">
                    @foreach ($material->videos as $video)
                        <div class="mb-4">
                            <div class="aspect-w-16 aspect-h-9">
                                <iframe 
                                    class="w-full h-64 rounded" 
                                    src="{{ Str::replace('watch?v=', 'embed/', $video->video_url) }}" 
                                    frameborder="0" 
                                    allowfullscreen>
                                </iframe>
                                <p class="font-medium">Ini merupakan video {{ $video->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

                {{-- IMAGE SECTION --}}
                @if ($material->images->count())
                    <div class="material-images mt-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($material->images as $image)
                                <div class="bg-white p-2 rounded shadow">
                                    <img src="{{ asset('storage/' . $image->image_url) }}" alt="{{ $image->description }}" class="w-full h-auto rounded mb-2">
                                    <p class="text-center text-sm text-gray-700">{{ $image->description }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

             <div class="material-desc">
                {!! nl2br(e($material->content)) !!}
            </div>
            @if ($material->is_submission_point && !$material->submissions->where('user_id', auth()->id())->first())
                <div class="submission-form mt-8 p-4 border rounded bg-gray-100">
                    <h2 class="text-lg font-semibold mb-2">Kumpulkan Tugas</h2>
                    <form action="{{ route('submission.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="material_id" value="{{ $material->id }}">

                        <label for="link" class="block font-medium mb-1">Link Google Drive</label>
                        <input type="url" name="link" id="link" class="w-full p-2 border rounded mb-3" placeholder="https://drive.google.com/..." required>

                        <label for="description" class="block font-medium mb-1">Deskripsi (Opsional)</label>
                        <textarea name="description" id="description" class="w-full p-2 border rounded mb-3" rows="2" placeholder="Catatan atau deskripsi singkat"></textarea>

                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Kumpulkan</button>
                    </form>
                </div>
            @elseif ($material->is_submission_point)
                <div class="mt-6 p-4 bg-green-100 border border-green-300 rounded">
                    <p class="text-green-700 font-semibold">✅ Tugas sudah dikumpulkan.</p>
                </div>
            @endif

                    @if ($material->tests->isNotEmpty())
            <div class="mt-6">
                <a href="{{ route('quiz.show', $material->slug) }}"
                class="inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    Kerjakan Kuis
                </a>
            </div>
        @endif

                @if ($material->tests->isNotEmpty())
                <a href="{{ route('quiz.show', $material->slug) }}" class="btn btn-primary mt-4">Kerjakan Kuis</a>
                  @endif
            <div class="material-nav-bottom">
                @if ($previous)
                    <a href="{{ route('materi.show', $previous->slug) }}" class="nav-back">Back</a>
                @else
                    <span class="nav-back text-gray-400 cursor-not-allowed">Back</span>
                @endif

                @if ($next)
                    <a href="{{ route('materi.show', $next->slug) }}" class="nav-next">Next</a>
                @else
                    <span class="nav-next text-gray-400 cursor-not-allowed">Next</span>
                @endif
            </div>
        </main>

        <aside class="material-sidebar-popup hidden" id="materialSidebar">
            <div class="sidebar-popup-overlay" id="sidebarOverlay"></div>
            <div class="sidebar-popup-content">
                <div class="sidebar-title">{{ $material->category->name }}</div>
                @foreach ($materials->groupBy('category_id') as $group)
                    <div class="sidebar-section">
                        <div class="sidebar-section-title">Materi</div>
                        <ul class="sidebar-list">
                            @foreach ($group as $item)
                                <li class="sidebar-item {{ $item->id === $material->id ? 'active' : '' }}">
                                    <a href="{{ route('materi.show', $item->slug) }}">
                                        <span class="sidebar-icon">
                                            {{ $item->id === $material->id ? '◉' : '○' }}
                                        </span>
                                        {{ $item->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </aside>
    </div>

    <script>
        document.getElementById('sidebarToggle').onclick = function() {
            document.getElementById('materialSidebar').classList.toggle('hidden');
        };
        document.getElementById('sidebarOverlay').onclick = function() {
            document.getElementById('materialSidebar').classList.add('hidden');
        };
    </script>
</div>
@endsection
