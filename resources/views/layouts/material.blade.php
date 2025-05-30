@extends('layouts.app')

@section('title', $material->title)

@section('content')
<div class="material-page">
    @include('components.material-navbar')

    <div class="material-body">
        <main class="material-main">
            <h1 class="material-title">{{ $material->title }}</h1>
            <div class="material-video">Video Placeholder</div>

            @if ($material->title)
                <h2 class="material-subtitle">{{ $material->title }}</h2>
            @endif

            <div class="material-desc">
                {!! nl2br(e($material->content)) !!}
            </div>

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
