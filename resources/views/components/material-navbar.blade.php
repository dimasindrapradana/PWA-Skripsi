<nav class="sticky top-0 z-30 w-full bg-white/90 border-b border-slate-200 shadow-sm flex items-center justify-between px-4 py-3">
    <a href="{{ route('user.dashboard') }}"
       class="mr-3 flex items-center justify-center px-3 h-10 rounded-lg border border-indigo-200 bg-white/80 hover:bg-indigo-50 text-indigo-600 font-semibold transition focus:outline-none focus:ring-2 focus:ring-indigo-200"
       aria-label="Kembali ke Beranda">
        <svg class="w-6 h-6 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        <span>Kembali</span>
    </a>

    <h1 class="flex-1 text-lg font-bold text-slate-800 text-center truncate px-2">
        {{ $material->title }}
    </h1>

    <button id="sidebarToggle" type="button"
        class="ml-3 flex items-center justify-center w-9 h-9 rounded hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-300 transition"
        aria-label="Buka navigasi materi">
        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>
</nav>
